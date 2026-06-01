@extends('layouts.app')
@section('title', 'Create Admin Account')

@section('content')

<div style="background:linear-gradient(135deg,#0f172a,#1e293b)" class="text-white py-4">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('superadmin.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
            <div>
                <h4 class="fw-bold mb-0"><i class="fas fa-user-shield me-2 text-warning"></i>Create Admin Account</h4>
                <p class="mb-0 opacity-75 small">Super Admin only</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">

                <div class="text-center mb-4">
                    <div style="width:64px;height:64px;background:linear-gradient(135deg,#4f46e5,#818cf8);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
                        <i class="fas fa-user-shield text-white fs-4"></i>
                    </div>
                    <h5 class="fw-bold mb-1">New Admin Account</h5>
                    <p class="text-muted small">This admin can post jobs, internships, and companies.</p>
                </div>

                @if($errors->any())
                <div class="alert alert-danger rounded-3 border-0 mb-4 small">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('superadmin.store-admin') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" name="name" class="form-control bg-light border-start-0" value="{{ old('name') }}" placeholder="Admin Full Name" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-start-0" value="{{ old('email') }}" placeholder="admin@careerhub.com" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="Min. 6 characters" required minlength="6">
                        </div>
                    </div>

                    <div class="p-3 bg-warning-soft rounded-3 mb-4 small">
                        <i class="fas fa-info-circle me-1 text-warning"></i>
                        This admin will be able to <strong>post jobs, internships, and companies</strong> but cannot manage users.
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-semibold flex-grow-1">
                            <i class="fas fa-user-plus me-2"></i>Create Admin
                        </button>
                        <a href="{{ route('superadmin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
