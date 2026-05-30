<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

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
