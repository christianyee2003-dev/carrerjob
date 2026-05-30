@extends('layouts.app')
@section('title', 'Internships')

@section('content')

<div class="page-header bg-primary-soft py-4">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-decoration-none text-primary">Home</a></li>
                <li class="breadcrumb-item active">Internships</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-0"><i class="fas fa-graduation-cap me-2 text-primary"></i>Internship Listings</h4>
                <p class="text-muted mb-0 small">{{ count($jobs) }} internship{{ count($jobs) !== 1 ? 's' : '' }} available</p>
            </div>
            <a href="{{ route('jobs') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="fas fa-briefcase me-1"></i>View Full-time Jobs
            </a>
        </div>
    </div>
</div>

<div class="container py-4">
    {{-- Search & Filter Bar --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <form action="{{ route('internships') }}" method="GET" id="filterForm">
            <div class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ $search }}" class="form-control border-start-0" placeholder="Search internships, skills, companies...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="setup" class="form-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Work Setups</option>
                        @foreach(['On-site','Hybrid','Remote'] as $s)
                        <option value="{{ $s }}" {{ $setup === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="salary" {{ $sort === 'salary' ? 'selected' : '' }}>Highest Salary</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                    @if($search || $setup)
                    <a href="{{ route('internships') }}" class="btn btn-outline-secondary rounded-pill px-2" title="Clear filters"><i class="fas fa-times"></i></a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Setup Filter Chips --}}
    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('internships') }}?search={{ urlencode($search) }}&sort={{ $sort }}"
           class="badge rounded-pill px-3 py-2 text-decoration-none {{ !$setup ? 'bg-primary text-white' : 'bg-light text-muted' }}">
            All
        </a>
        @foreach(['On-site','Hybrid','Remote'] as $s)
        <a href="{{ route('internships') }}?search={{ urlencode($search) }}&sort={{ $sort }}&setup={{ $s }}"
           class="badge rounded-pill px-3 py-2 text-decoration-none {{ $setup === $s ? 'bg-primary text-white' : 'bg-light text-muted' }}">
            <i class="fas fa-{{ $s === 'Remote' ? 'wifi' : ($s === 'Hybrid' ? 'code-branch' : 'building') }} me-1"></i>{{ $s }}
        </a>
        @endforeach
    </div>

    @if(count($jobs) === 0)
    <div class="text-center py-5">
        <div class="empty-state-icon mx-auto mb-3"><i class="fas fa-search fa-2x text-muted"></i></div>
        <h5 class="fw-bold">No internships found</h5>
        <p class="text-muted">Try adjusting your search or filters.</p>
        <a href="{{ route('internships') }}" class="btn btn-primary rounded-pill px-4">Clear Filters</a>
    </div>
    @else
    <div class="row g-4">
        @foreach($jobs as $job)
        <div class="col-md-6 col-lg-4">
            @include('partials.job-card', ['job' => $job])
        </div>
        @endforeach
    </div>

    {{-- Pagination UI --}}
    <nav class="mt-5 d-flex justify-content-center" aria-label="Page navigation">
        <ul class="pagination gap-1">
            <li class="page-item disabled">
                <span class="page-link rounded-pill border-0 bg-light">&laquo;</span>
            </li>
            @for($i = 1; $i <= 3; $i++)
            <li class="page-item {{ $i === 1 ? 'active' : '' }}">
                <a class="page-link rounded-pill border-0 {{ $i === 1 ? '' : 'bg-light text-muted' }}" href="#">{{ $i }}</a>
            </li>
            @endfor
            <li class="page-item">
                <a class="page-link rounded-pill border-0 bg-light text-muted" href="#">&raquo;</a>
            </li>
        </ul>
    </nav>
    @endif
</div>
@endsection
