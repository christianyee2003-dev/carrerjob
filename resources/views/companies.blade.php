@extends('layouts.app')
@section('title', 'Companies')

@section('content')

<div class="page-header bg-primary-soft py-4">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-decoration-none text-primary">Home</a></li>
                <li class="breadcrumb-item active">Companies</li>
            </ol>
        </nav>
        <h4 class="fw-bold mb-0"><i class="fas fa-building me-2 text-primary"></i>Top Companies Hiring</h4>
        <p class="text-muted mb-0 small">{{ count($companies) }} companies with open positions</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        @foreach($companies as $co)
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('jobs') }}?search={{ urlencode($co['name']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center hover-card h-100">
                    <div class="company-logo-lg rounded-4 d-flex align-items-center justify-content-center text-white fw-bold fs-2 logo-{{ $co['logo'] }} mx-auto mb-3">
                        {{ strtoupper(substr($co['name'], 0, 1)) }}
                    </div>
                    <h6 class="fw-bold text-dark mb-1">{{ $co['name'] }}</h6>
                    <p class="text-muted small mb-3">{{ $co['industry'] }}</p>
                    <span class="badge bg-primary-soft text-primary rounded-pill px-3 py-2">
                        <i class="fas fa-briefcase me-1"></i>
                        {{ $co['jobs'] }} open {{ $co['jobs'] === 1 ? 'role' : 'roles' }}
                    </span>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Jobs by company section --}}
    <div class="mt-5">
        <h5 class="fw-bold mb-4">All Open Positions</h5>
        <div class="row g-4">
            @foreach($allJobs as $job)
            <div class="col-md-6 col-lg-4">
                @include('partials.job-card', ['job' => $job])
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
