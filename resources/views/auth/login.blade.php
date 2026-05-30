@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="auth-page d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center align-items-center g-5">

            {{-- Form --}}
            <div class="col-md-5">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
                    <div class="text-center mb-4">
                        <a href="{{ route('landing') }}" class="text-decoration-none">
                            <div class="ch-brand justify-content-center mb-2" style="font-size:1.4rem;display:flex;align-items:center;gap:8px">
                                <span class="brand-icon"><i class="fas fa-briefcase"></i></span>
                                Career<span class="text-primary">Hub</span>
                            </div>
                        </a>
                        <h5 class="fw-bold mt-3 mb-1">Welcome Back!</h5>
                        <p class="text-muted small">Sign in to continue your career journey</p>
                    </div>

                    @if($errors->any())
                    <div class="alert alert-danger rounded-3 border-0 small py-2">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                    </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
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
                                <input type="password" name="password" id="pwInput" class="form-control bg-light border-start-0 border-end-0 border-light-subtle" placeholder="••••••••" required>
                                <button type="button" class="input-group-text bg-light border-start-0 border-light-subtle" onclick="togglePw()">
                                    <i class="fas fa-eye text-muted" id="pwEye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small text-muted" for="remember">Remember me</label>
                            </div>
                            <a href="#" class="text-primary small text-decoration-none">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </form>

                    
                    <p class="text-center text-muted small mb-0">
                        Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Sign Up Free</a>
                    </p>

                    
                </div>
            </div>

            {{-- Illustration --}}
            <div class="col-md-5 d-none d-md-block">
                <div class="text-center">
                    <svg viewBox="0 0 400 420" xmlns="http://www.w3.org/2000/svg" class="img-fluid" style="max-width:360px">
                        <circle cx="200" cy="210" r="185" fill="#eef2ff"/>
                        <rect x="70" y="140" width="260" height="200" rx="18" fill="#fff" stroke="#e0e7ff" stroke-width="2"/>
                        <rect x="70" y="140" width="260" height="52" rx="18" fill="#4f46e5"/>
                        <rect x="70" y="170" width="260" height="22" fill="#4f46e5"/>
                        <circle cx="100" cy="166" r="8" fill="#818cf8"/>
                        <circle cx="124" cy="166" r="8" fill="#a5b4fc"/>
                        <circle cx="148" cy="166" r="8" fill="#c7d2fe"/>
                        <rect x="100" y="210" width="200" height="12" rx="6" fill="#e0e7ff"/>
                        <rect x="100" y="232" width="150" height="10" rx="5" fill="#e0e7ff"/>
                        <rect x="100" y="260" width="90" height="36" rx="10" fill="#4f46e5"/>
                        <text x="145" y="283" fill="white" font-size="13" text-anchor="middle" font-family="Inter,sans-serif" font-weight="600">Login</text>
                        <circle cx="330" cy="130" r="42" fill="#818cf8" opacity=".2"/>
                        <circle cx="75"  cy="330" r="32" fill="#4f46e5" opacity=".15"/>
                        <circle cx="200" cy="75"  r="32" fill="#fbbf24" opacity=".3"/>
                        <circle cx="310" cy="340" r="22" fill="#34d399" opacity=".25"/>
                    </svg>
                    <h5 class="fw-bold mt-3">Your Career Starts Here</h5>
                    <p class="text-muted small">Access hundreds of internships and jobs from top companies across the Philippines.</p>
                    <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
                        @foreach(['Google','Meta','Amazon','Microsoft','Apple'] as $co)
                        <span class="badge bg-white shadow-sm text-dark rounded-pill px-3 py-2 small">{{ $co }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function togglePw() {
    const i = document.getElementById('pwInput');
    const e = document.getElementById('pwEye');
    i.type = i.type === 'password' ? 'text' : 'password';
    e.className = i.type === 'password' ? 'fas fa-eye text-muted' : 'fas fa-eye-slash text-muted';
}
</script>
@endsection
