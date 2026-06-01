@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

<div class="bg-dark text-white py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-0"><i class="fas fa-shield-alt me-2 text-warning"></i>Admin Dashboard</h4>
                <p class="mb-0 opacity-75 small">Logged in as <strong>{{ session('user.name') }}</strong> — admin1</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i>Post Job
                </a>
                <a href="{{ route('admin.internships.create') }}" class="btn btn-success rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i>Post Internship
                </a>
                <a href="{{ route('admin.companies.create') }}" class="btn btn-warning rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i>Add Company
                </a>
                <a href="{{ route('landing') }}" class="btn btn-outline-light rounded-pill px-3">
                    <i class="fas fa-eye me-1"></i>View Site
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">

    @if(session('success'))
    <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4 d-flex align-items-center gap-2">
        <i class="fas fa-check-circle fs-5"></i>{{ session('success') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-5">
        @foreach([
            ['icon'=>'fas fa-briefcase','color'=>'primary','value'=>count($jobs),'label'=>'Jobs Posted'],
            ['icon'=>'fas fa-graduation-cap','color'=>'success','value'=>count($internships),'label'=>'Internships Posted'],
            ['icon'=>'fas fa-building','color'=>'warning','value'=>count($companies),'label'=>'Companies Added'],
        ] as $s)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                <div class="stat-icon bg-{{ $s['color'] }}-soft text-{{ $s['color'] }} rounded-3 mx-auto mb-2">
                    <i class="{{ $s['icon'] }}"></i>
                </div>
                <div class="fw-bold fs-2">{{ $s['value'] }}</div>
                <div class="text-muted">{{ $s['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs border-0 mb-4 gap-1" id="adminTabs">
        <li class="nav-item">
            <a class="nav-link active rounded-pill px-4" data-bs-toggle="tab" href="#tabJobs">
                <i class="fas fa-briefcase me-1"></i>Jobs <span class="badge bg-primary ms-1">{{ count($jobs) }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4" data-bs-toggle="tab" href="#tabInternships">
                <i class="fas fa-graduation-cap me-1"></i>Internships <span class="badge bg-success ms-1">{{ count($internships) }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link rounded-pill px-4" data-bs-toggle="tab" href="#tabCompanies">
                <i class="fas fa-building me-1"></i>Companies <span class="badge bg-warning text-dark ms-1">{{ count($companies) }}</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">

        {{-- JOBS TAB --}}
        <div class="tab-pane fade show active" id="tabJobs">
            @if(count($jobs) === 0)
            <div class="text-center py-5">
                <i class="fas fa-briefcase fa-3x text-muted opacity-25 mb-3 d-block"></i>
                <p class="text-muted">No jobs posted yet.</p>
                <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-plus me-1"></i>Post First Job
                </a>
            </div>
            @else
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Job Title</th>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th>Setup</th>
                                <th>Posted</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $job)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold">{{ $job['title'] }}</div>
                                    <small class="text-muted">ID: {{ $job['id'] }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="company-logo-sm rounded-2 d-flex align-items-center justify-content-center text-white fw-bold logo-{{ $job['logo'] }}" style="width:28px;height:28px;font-size:11px">
                                            {{ strtoupper(substr($job['company'], 0, 1)) }}
                                        </div>
                                        {{ $job['company'] }}
                                    </div>
                                </td>
                                <td class="text-muted small">{{ $job['location'] }}</td>
                                <td class="text-primary fw-semibold small">{{ $job['salary'] }}</td>
                                <td><span class="badge bg-light text-muted rounded-pill">{{ $job['setup'] }}</span></td>
                                <td class="text-muted small">{{ $job['created_at'] ?? 'N/A' }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('jobs.show', $job['id']) }}" class="btn btn-outline-primary btn-sm rounded-pill px-2" target="_blank" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.jobs.edit', $job['id']) }}" class="btn btn-outline-warning btn-sm rounded-pill px-2" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.jobs.delete', $job['id']) }}" method="POST" onsubmit="return confirm('Delete this job?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm rounded-pill px-2" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- INTERNSHIPS TAB --}}
        <div class="tab-pane fade" id="tabInternships">
            @if(count($internships) === 0)
            <div class="text-center py-5">
                <i class="fas fa-graduation-cap fa-3x text-muted opacity-25 mb-3 d-block"></i>
                <p class="text-muted">No internships posted yet.</p>
                <a href="{{ route('admin.internships.create') }}" class="btn btn-success rounded-pill px-4">
                    <i class="fas fa-plus me-1"></i>Post First Internship
                </a>
            </div>
            @else
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Title</th>
                                <th>Company</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th>Duration</th>
                                <th>Posted</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($internships as $slug => $intern)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $intern['title'] }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="company-logo-sm rounded-2 d-flex align-items-center justify-content-center text-white fw-bold bg-primary" style="width:28px;height:28px;font-size:11px">
                                            {{ strtoupper(substr($intern['company'], 0, 1)) }}
                                        </div>
                                        {{ $intern['company'] }}
                                    </div>
                                </td>
                                <td class="text-muted small">{{ $intern['location'] }}</td>
                                <td class="text-primary fw-semibold small">{{ $intern['salary'] }}</td>
                                <td><span class="badge bg-light text-muted rounded-pill">{{ $intern['duration'] }}</span></td>
                                <td class="text-muted small">{{ $intern['created_at'] ?? 'N/A' }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('internship.show', $slug) }}" class="btn btn-outline-primary btn-sm rounded-pill px-2" target="_blank" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.internships.delete', $slug) }}" method="POST" onsubmit="return confirm('Delete this internship?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger btn-sm rounded-pill px-2" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- COMPANIES TAB --}}
        <div class="tab-pane fade" id="tabCompanies">
            @if(count($companies) === 0)
            <div class="text-center py-5">
                <i class="fas fa-building fa-3x text-muted opacity-25 mb-3 d-block"></i>
                <p class="text-muted">No companies added yet.</p>
                <a href="{{ route('admin.companies.create') }}" class="btn btn-warning rounded-pill px-4">
                    <i class="fas fa-plus me-1"></i>Add First Company
                </a>
            </div>
            @else
            <div class="row g-3">
                @foreach($companies as $idx => $co)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="company-logo rounded-3 d-flex align-items-center justify-content-center text-white fw-bold bg-primary logo-{{ $co['logo'] }}">
                                {{ strtoupper(substr($co['name'], 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ $co['name'] }}</div>
                                <small class="text-muted">{{ $co['industry'] }}</small>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Added {{ $co['created_at'] ?? 'N/A' }}</small>
                            <form action="{{ route('admin.companies.delete', $idx) }}" method="POST" onsubmit="return confirm('Delete this company?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm rounded-pill px-2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
