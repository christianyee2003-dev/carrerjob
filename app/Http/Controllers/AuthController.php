<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required']);
        // Static demo credentials
        $users = [
            ['email' => 'student@careerhub.com', 'password' => 'password', 'name' => 'Juan dela Cruz', 'role' => 'student'],
            ['email' => 'employer@careerhub.com', 'password' => 'password', 'name' => 'HR Manager', 'role' => 'employer'],
        ];
        $user = collect($users)->firstWhere('email', $request->email);
        if ($user && $user['password'] === $request->password) {
            session(['user' => $user]);
            return redirect()->route('dashboard')->with('success', 'Welcome back, ' . $user['name'] . '!');
        }
        return back()->withErrors(['email' => 'Invalid credentials. Try student@careerhub.com / password'])->withInput();
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:student,employer',
        ]);
        session(['user' => ['name' => $request->name, 'email' => $request->email, 'role' => $request->role]]);
        return redirect()->route('dashboard')->with('success', 'Account created! Welcome to CareerHub.');
    }

    public function logout()
    {
        session()->forget(['user', 'saved_jobs', 'applied_jobs']);
        return redirect()->route('landing');
    }
}
