@extends('layouts.app')
@section('title', 'Verify Your Email')

@section('content')
<div class="auth-page d-flex align-items-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 text-center">

                    {{-- Icon --}}
                    <div class="mb-4">
                        <div style="width:80px;height:80px;background:linear-gradient(135deg,#4f46e5,#818cf8);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                            <i class="fas fa-envelope-open-text text-white" style="font-size:2rem"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Check Your Email</h4>
                        <p class="text-muted small">We sent a verification link to</p>
                        @if($email)
                        <div class="badge bg-primary-soft text-primary rounded-pill px-4 py-2 fs-6">
                            <i class="fas fa-envelope me-2"></i>{{ $email }}
                        </div>
                        @endif
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success rounded-3 border-0 small mb-3">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                    @endif

                    @if(session('warning'))
                    <div class="alert alert-warning rounded-3 border-0 small mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger rounded-3 border-0 small mb-3">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                    </div>
                    @endif

                    <div class="bg-light rounded-3 p-3 mb-4 text-start small">
                        <div class="d-flex align-items-start gap-2 mb-2">
                            <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                            <span>Open your email inbox</span>
                        </div>
                        <div class="d-flex align-items-start gap-2 mb-2">
                            <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                            <span>Click the <strong>"Verify Email Address"</strong> button</span>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <i class="fas fa-check-circle text-success mt-1 flex-shrink-0"></i>
                            <span>Link expires in <strong>24 hours</strong></span>
                        </div>
                    </div>

                    {{-- Resend --}}
                    <form action="{{ route('verify.resend') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="btn btn-outline-primary w-100 rounded-pill py-2">
                            <i class="fas fa-redo me-2"></i>Resend Verification Email
                        </button>
                    </form>

                    <a href="{{ route('login') }}" class="btn btn-light w-100 rounded-pill py-2 text-muted">
                        <i class="fas fa-arrow-left me-2"></i>Back to Login
                    </a>

                    <p class="text-muted mt-3 mb-0" style="font-size:12px">
                        Didn't receive it? Check your spam folder or resend above.
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
