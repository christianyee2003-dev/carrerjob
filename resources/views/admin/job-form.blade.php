@extends('layouts.app')
@section('title', $editId ? 'Edit Job' : 'Post New Job')

@section('content')

<div class="bg-dark text-white py-4">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
            <div>
                <h4 class="fw-bold mb-0">
                    <i class="fas fa-{{ $editId ? 'edit' : 'plus-circle' }} me-2 text-primary"></i>
                    {{ $editId ? 'Edit Job' : 'Post New Job' }}
                </h4>
                <p class="mb-0 opacity-75 small">Admin only — CareerHub</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">

                @if($errors->any())
                <div class="alert alert-danger rounded-3 border-0 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ $editId ? route('admin.jobs.update', $editId) : route('admin.jobs.store') }}" method="POST">
                    @csrf
                    @if($editId) @method('PUT') @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Job Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control rounded-3" value="{{ old('title', $job['title'] ?? '') }}" placeholder="e.g. Frontend Developer" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company" class="form-control rounded-3" value="{{ old('company', $job['company'] ?? '') }}" placeholder="e.g. Google" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control rounded-3" value="{{ old('location', $job['location'] ?? '') }}" placeholder="e.g. Makati, PH" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Salary <span class="text-danger">*</span></label>
                            <input type="text" name="salary" class="form-control rounded-3" value="{{ old('salary', $job['salary'] ?? '') }}" placeholder="e.g. ₱50,000/mo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Work Setup <span class="text-danger">*</span></label>
                            <select name="setup" class="form-select rounded-3" required>
                                @foreach(['On-site','Hybrid','Remote'] as $s)
                                <option value="{{ $s }}" {{ old('setup', $job['setup'] ?? '') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Experience Required</label>
                            <input type="text" name="experience" class="form-control rounded-3" value="{{ old('experience', $job['experience'] ?? '') }}" placeholder="e.g. 2+ years">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Skills / Tags <span class="text-muted">(comma separated)</span></label>
                            <input type="text" name="tags" class="form-control rounded-3" value="{{ old('tags', isset($job['tags']) ? implode(', ', $job['tags']) : '') }}" placeholder="e.g. React, PHP, MySQL">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Job Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control rounded-3" rows="4" placeholder="Describe the role..." required>{{ old('description', $job['description'] ?? '') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Responsibilities <span class="text-muted">(one per line)</span></label>
                            <textarea name="responsibilities" class="form-control rounded-3" rows="4" placeholder="Build responsive UI&#10;Write clean code&#10;Participate in code reviews">{{ old('responsibilities', isset($job['responsibilities']) ? implode("\n", $job['responsibilities']) : '') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Requirements <span class="text-muted">(one per line)</span></label>
                            <textarea name="requirements" class="form-control rounded-3" rows="4" placeholder="3+ years experience&#10;Proficiency in PHP&#10;Strong communication skills">{{ old('requirements', isset($job['requirements']) ? implode("\n", $job['requirements']) : '') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Benefits <span class="text-muted">(comma separated)</span></label>
                            <input type="text" name="benefits" class="form-control rounded-3" value="{{ old('benefits', isset($job['benefits']) ? implode(', ', $job['benefits']) : '') }}" placeholder="e.g. Health insurance, Stock options, Remote work">
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-semibold">
                            <i class="fas fa-{{ $editId ? 'save' : 'paper-plane' }} me-2"></i>
                            {{ $editId ? 'Update Job' : 'Post Job' }}
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
