@extends('layouts.app')
@section('title', 'Create Account')

@section('content')
<div class="auth-page d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
                    <div class="text-center mb-4">
                        <a href="{{ route('landing') }}" class="text-decoration-none">
                            <div class="ch-brand justify-content-center mb-2" style="font-size:1.4rem;display:flex;align-items:center;gap:8px">
                                <span class="brand-icon"><i class="fas fa-briefcase"></i></span>
                                Career<span class="text-primary">Hub</span>
                            </div>
                        </a>
                        <h5 class="fw-bold mt-3 mb-1">Create Your Account</h5>
                        <p class="text-muted small">Join thousands of students finding their dream careers</p>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger rounded-3 border-0 small py-2">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        {{-- Role Selection --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">I am a...</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="roleStudent" value="student" checked>
                                    <label class="btn btn-outline-primary w-100 rounded-3 py-3" for="roleStudent">
                                        <i class="fas fa-graduation-cap d-block fs-3 mb-1"></i>
                                        <span class="fw-semibold">Student</span>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="roleEmployer" value="employer">
                                    <label class="btn btn-outline-primary w-100 rounded-3 py-3" for="roleEmployer">
                                        <i class="fas fa-building d-block fs-3 mb-1"></i>
                                        <span class="fw-semibold">Employer</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 border-light-subtle"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control bg-light border-start-0 border-light-subtle" placeholder="Juan dela Cruz" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 border-light-subtle"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control bg-light border-start-0 border-light-subtle" placeholder="you@example.com" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 border-light-subtle"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-start-0 border-light-subtle" placeholder="Min. 6 characters" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 border-light-subtle"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" name="password_confirmation" class="form-control bg-light border-start-0 border-light-subtle" placeholder="Repeat password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold mb-3">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                    </form>

                    <div class="divider-text text-muted small mb-3">or</div>

                    

                    <p class="text-center text-muted small mb-0">
                        Already have an account? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
