@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- Hero Banner --}}
<div class="dashboard-banner">
    <div class="container py-4">
        <div class="row align-items-center g-3">
            <div class="col-md-5">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-lg">{{ strtoupper(substr(session('user.name', 'G'), 0, 1)) }}</div>
                    <div>
                        <p class="text-white opacity-75 mb-0 small">
                            Good {{ date('H') < 12 ? 'Morning' : (date('H') < 17 ? 'Afternoon' : 'Evening') }} 👋
                        </p>
                        <h4 class="fw-bold text-white mb-0">{{ session('user.name', 'Guest') }}</h4>
                        <span class="badge bg-white bg-opacity-25 text-white rounded-pill mt-1">
                            <i class="fas fa-{{ session('user.role') === 'employer' ? 'building' : 'graduation-cap' }} me-1"></i>
                            {{ ucfirst(session('user.role', 'Student')) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <form action="{{ route('jobs') }}" method="GET">
                    <div class="input-group shadow">
                        <span class="input-group-text bg-white border-0 ps-3"><i class="fas fa-search text-primary"></i></span>
                        <input type="text" name="search" class="form-control border-0 py-3" placeholder="Search jobs, companies, skills...">
                        <button class="btn btn-warning fw-semibold px-4 border-0" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">

    {{-- ===== FEATURED INTERNSHIPS (TOP) ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="section-label">For Students</span>
            <h5 class="fw-bold mb-0">Featured Internships</h5>
            <p class="text-muted small mb-0">Top internship picks for you</p>
        </div>
        <a href="{{ route('internships') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
            View All <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="row g-4 mb-5">
        @foreach($featuredInternships as $job)
        <div class="col-md-6 col-lg-4">
            @include('partials.job-card', ['job' => $job])
        </div>
        @endforeach
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-5">
        @foreach([
            ['icon'=>'fas fa-briefcase','color'=>'primary','value'=>'500+','label'=>'Total Jobs','link'=>route('jobs')],
            ['icon'=>'fas fa-graduation-cap','color'=>'success','value'=>'200+','label'=>'Internships','link'=>route('internships')],
            ['icon'=>'fas fa-building','color'=>'warning','value'=>'150+','label'=>'Companies','link'=>route('companies')],
            ['icon'=>'fas fa-bookmark','color'=>'info','value'=>$savedCount,'label'=>'Saved Jobs','link'=>route('profile')],
            ['icon'=>'fas fa-paper-plane','color'=>'danger','value'=>$appliedCount,'label'=>'Applied','link'=>route('profile')],
        ] as $stat)
        <div class="col-6 col-md-4 col-lg">
            <a href="{{ $stat['link'] }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center hover-card h-100">
                    <div class="stat-icon bg-{{ $stat['color'] }}-soft text-{{ $stat['color'] }} rounded-3 mx-auto mb-2">
                        <i class="{{ $stat['icon'] }}"></i>
                    </div>
                    <div class="fw-bold fs-4 lh-1">{{ $stat['value'] }}</div>
                    <div class="text-muted small mt-1">{{ $stat['label'] }}</div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Quick Actions --}}
    <div class="row g-3 mb-5">
        <div class="col-12">
            <h6 class="fw-bold mb-3">Quick Actions</h6>
        </div>
        @foreach([
            ['icon'=>'fas fa-search','color'=>'primary','label'=>'Browse Internships','link'=>route('internships')],
            ['icon'=>'fas fa-briefcase','color'=>'success','label'=>'Browse Jobs','link'=>route('jobs')],
            ['icon'=>'fas fa-building','color'=>'warning','label'=>'View Companies','link'=>route('companies')],
            ['icon'=>'fas fa-user','color'=>'info','label'=>'My Profile','link'=>route('profile')],
        ] as $qa)
        <div class="col-6 col-md-3">
            <a href="{{ $qa['link'] }}" class="card border-0 shadow-sm rounded-4 p-3 text-center hover-card text-decoration-none d-block">
                <div class="feature-icon bg-{{ $qa['color'] }}-soft text-{{ $qa['color'] }} rounded-3 mx-auto mb-2">
                    <i class="{{ $qa['icon'] }} fs-5"></i>
                </div>
                <div class="fw-semibold small text-dark">{{ $qa['label'] }}</div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Recommended Jobs --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="section-label">Full-time</span>
            <h5 class="fw-bold mb-0">Recommended Jobs</h5>
            <p class="text-muted small mb-0">Full-time positions for you</p>
        </div>
        <a href="{{ route('jobs') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
            View All <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="row g-4">
        @foreach($recommendedJobs as $job)
        <div class="col-md-6 col-lg-4">
            @include('partials.job-card', ['job' => $job])
        </div>
        @endforeach
    </div>

</div>
@endsection
