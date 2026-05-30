@extends('layouts.app')
@section('title', 'My Profile')

@section('content')

<div class="page-header bg-primary-soft py-4">
    <div class="container">
        <h4 class="fw-bold mb-0"><i class="fas fa-user-circle me-2 text-primary"></i>My Profile</h4>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">

        {{-- ===== SIDEBAR ===== --}}
        <div class="col-lg-3">
            {{-- Profile Card --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center mb-3">
                <div class="avatar-circle mx-auto mb-3">
                    {{ strtoupper(substr($user['name'], 0, 1)) }}
                </div>
                <h6 class="fw-bold mb-0">{{ $user['name'] }}</h6>
                <p class="text-muted small mb-2">{{ $user['email'] }}</p>
                <span class="badge bg-primary-soft text-primary rounded-pill px-3 py-2">
                    <i class="fas fa-{{ $user['role'] === 'student' ? 'graduation-cap' : 'building' }} me-1"></i>
                    {{ ucfirst($user['role']) }}
                </span>
                <div class="d-flex justify-content-center gap-3 mt-3 pt-3 border-top">
                    <div class="text-center">
                        <div class="fw-bold text-primary">{{ count($savedJobs) }}</div>
                        <div class="text-muted" style="font-size:11px">Saved</div>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold text-success">{{ count($appliedJobs) }}</div>
                        <div class="text-muted" style="font-size:11px">Applied</div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Nav --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="list-group list-group-flush">
                    @foreach([
                        ['icon'=>'fas fa-user','label'=>'Profile','route'=>'profile','active'=>true],
                        ['icon'=>'fas fa-th-large','label'=>'Dashboard','route'=>'dashboard','active'=>false],
                        ['icon'=>'fas fa-briefcase','label'=>'Browse Jobs','route'=>'jobs','active'=>false],
                        ['icon'=>'fas fa-graduation-cap','label'=>'Internships','route'=>'internships','active'=>false],
                        ['icon'=>'fas fa-building','label'=>'Companies','route'=>'companies','active'=>false],
                    ] as $nav)
                    <a href="{{ route($nav['route']) }}" class="list-group-item list-group-item-action border-0 py-3 d-flex align-items-center gap-2 {{ $nav['active'] ? 'active' : '' }}">
                        <i class="{{ $nav['icon'] }} {{ $nav['active'] ? '' : 'text-muted' }}"></i>
                        {{ $nav['label'] }}
                    </a>
                    @endforeach
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action border-0 py-3 text-danger w-100 text-start d-flex align-items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="col-lg-9">

            {{-- Skills --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="fas fa-code me-2 text-primary"></i>Skills</h6>
                    <button class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fas fa-plus me-1"></i>Add Skill
                    </button>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($skills as $skill)
                    <span class="skill-tag">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Saved Jobs --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-bookmark me-2 text-warning"></i>Saved Jobs
                        <span class="badge bg-warning text-dark rounded-pill ms-1">{{ count($savedJobs) }}</span>
                    </h6>
                    <a href="{{ route('jobs') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Browse More</a>
                </div>
                @if(count($savedJobs) === 0)
                <div class="text-center py-4">
                    <i class="fas fa-bookmark fa-2x text-muted opacity-25 mb-2 d-block"></i>
                    <p class="text-muted small mb-2">No saved jobs yet.</p>
                    <a href="{{ route('jobs') }}" class="btn btn-primary btn-sm rounded-pill px-3">Browse Jobs</a>
                </div>
                @else
                <div class="row g-3">
                    @foreach($savedJobs as $job)
                    <div class="col-md-6">
                        <a href="{{ route('jobs.show', $job['id']) }}" class="text-decoration-none">
                            <div class="card border rounded-3 p-3 hover-card h-100">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="company-logo-sm rounded-2 d-flex align-items-center justify-content-center text-white fw-bold logo-{{ $job['logo'] }}">
                                        {{ strtoupper(substr($job['company'], 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small text-dark">{{ $job['title'] }}</div>
                                        <div class="text-muted" style="font-size:11px">{{ $job['company'] }} · {{ $job['location'] }}</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-primary fw-semibold small">{{ $job['salary'] }}</span>
                                    <span class="badge rounded-pill {{ $job['type'] === 'internship' ? 'bg-success-soft text-success' : 'bg-primary-soft text-primary' }}" style="font-size:10px">
                                        {{ $job['type'] === 'internship' ? 'Internship' : 'Full-time' }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Applied Jobs --}}
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-paper-plane me-2 text-success"></i>Applied Jobs
                        <span class="badge bg-success text-white rounded-pill ms-1">{{ count($appliedJobs) }}</span>
                    </h6>
                </div>
                @if(count($appliedJobs) === 0)
                <div class="text-center py-4">
                    <i class="fas fa-paper-plane fa-2x text-muted opacity-25 mb-2 d-block"></i>
                    <p class="text-muted small mb-2">You haven't applied to any jobs yet.</p>
                    <a href="{{ route('internships') }}" class="btn btn-primary btn-sm rounded-pill px-3">Browse Internships</a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="small fw-semibold border-0">Position</th>
                                <th class="small fw-semibold border-0">Company</th>
                                <th class="small fw-semibold border-0">Type</th>
                                <th class="small fw-semibold border-0">Status</th>
                                <th class="border-0"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appliedJobs as $job)
                            <tr>
                                <td class="fw-semibold small">{{ $job['title'] }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="company-logo-sm rounded-2 d-flex align-items-center justify-content-center text-white fw-bold logo-{{ $job['logo'] }}" style="width:28px;height:28px;font-size:11px">
                                            {{ strtoupper(substr($job['company'], 0, 1)) }}
                                        </div>
                                        <span class="text-muted small">{{ $job['company'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{ $job['type'] === 'internship' ? 'bg-success-soft text-success' : 'bg-primary-soft text-primary' }}" style="font-size:10px">
                                        {{ $job['type'] === 'internship' ? 'Internship' : 'Full-time' }}
                                    </span>
                                </td>
                                <td><span class="badge bg-warning-soft text-warning rounded-pill" style="font-size:10px">Under Review</span></td>
                                <td>
                                    <a href="{{ route('jobs.show', $job['id']) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3" style="font-size:11px">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
