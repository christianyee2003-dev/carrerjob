<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;

// Landing & Dashboard
Route::get('/',          [HomeController::class,    'landing'])->name('landing');
Route::get('/dashboard', [HomeController::class,    'dashboard'])->name('dashboard');
Route::get('/companies', [HomeController::class,    'companies'])->name('companies');

// Auth
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Email Verification
Route::get('/verify',              [AuthController::class, 'showVerifyNotice'])->name('verify.notice');
Route::get('/verify/{token}',      [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::post('/verify/resend',      [AuthController::class, 'resendVerification'])->name('verify.resend');

// Internships — list + per-company detail
Route::get('/internships',           [InternshipController::class, 'index'])->name('internships');
Route::get('/internships/{company}', [InternshipController::class, 'show'])->name('internship.show');

// Internship save/apply (reuse job session helpers)
Route::post('/internships/{company}/apply', function (string $company) {
    $applied = session('applied_internships', []);
    if (!in_array($company, $applied)) {
        $applied[] = $company;
        session(['applied_internships' => $applied]);
    }
    return back()->with('success', 'Application submitted successfully! 🎉');
})->name('internship.apply');

Route::post('/internships/{company}/save', function (string $company) {
    $saved = session('saved_internships', []);
    if (in_array($company, $saved)) {
        $saved  = array_values(array_diff($saved, [$company]));
        $status = 'removed';
    } else {
        $saved[] = $company;
        $status  = 'saved';
    }
    session(['saved_internships' => $saved]);
    return response()->json(['status' => $status]);
})->name('internship.save');

// Jobs — list + per-id detail
Route::get('/jobs',          [JobController::class, 'listings'])->name('jobs');
Route::get('/jobs/{id}',     [JobController::class, 'show'])->name('jobs.show')->where('id', '[0-9]+');
Route::post('/jobs/{id}/save',  [JobController::class, 'saveJob'])->name('jobs.save');
Route::post('/jobs/{id}/apply', [JobController::class, 'apply'])->name('jobs.apply');

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// ── ADMIN (admin1 only) ───────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                          [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/jobs/create',               [AdminController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs',                     [AdminController::class, 'storeJob'])->name('jobs.store');
    Route::get('/jobs/{id}/edit',            [AdminController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{id}',                 [AdminController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/jobs/{id}',              [AdminController::class, 'deleteJob'])->name('jobs.delete');
    Route::get('/internships/create',        [AdminController::class, 'createInternship'])->name('internships.create');
    Route::post('/internships',              [AdminController::class, 'storeInternship'])->name('internships.store');
    Route::delete('/internships/{slug}',     [AdminController::class, 'deleteInternship'])->name('internships.delete');
    Route::get('/companies/create',          [AdminController::class, 'createCompany'])->name('companies.create');
    Route::post('/companies',                [AdminController::class, 'storeCompany'])->name('companies.store');
    Route::delete('/companies/{idx}',        [AdminController::class, 'deleteCompany'])->name('companies.delete');
});

// ── SUPER ADMIN ────────────────────────────────────────────────────
Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/',                              [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/create-admin',                  [SuperAdminController::class, 'createAdmin'])->name('create-admin');
    Route::post('/create-admin',                 [SuperAdminController::class, 'storeAdmin'])->name('store-admin');
    Route::post('/users/{id}/ban',               [SuperAdminController::class, 'banUser'])->name('ban');
    Route::post('/users/{id}/unban',             [SuperAdminController::class, 'unbanUser'])->name('unban');
    Route::post('/users/{id}/role',              [SuperAdminController::class, 'changeRole'])->name('role');
    Route::post('/users/{id}/toggle-admin',      [SuperAdminController::class, 'toggleAdmin'])->name('toggle-admin');
    Route::post('/users/{id}/reset-password',    [SuperAdminController::class, 'resetPassword'])->name('reset-password');
    Route::delete('/users/{id}',                 [SuperAdminController::class, 'deleteUser'])->name('delete');
});
