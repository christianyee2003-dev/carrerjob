@extends('layouts.app')
@section('title', 'Post New Internship')

@section('content')

<div class="bg-dark text-white py-4">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
            <div>
                <h4 class="fw-bold mb-0"><i class="fas fa-graduation-cap me-2 text-success"></i>Post New Internship</h4>
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

                <form action="{{ route('admin.internships.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Internship Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control rounded-3" value="{{ old('title') }}" placeholder="e.g. Frontend Developer Intern" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company" class="form-control rounded-3" value="{{ old('company') }}" placeholder="e.g. Google" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control rounded-3" value="{{ old('location') }}" placeholder="e.g. Makati, PH" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Salary / Allowance <span class="text-danger">*</span></label>
                            <input type="text" name="salary" class="form-control rounded-3" value="{{ old('salary') }}" placeholder="e.g. ₱15,000/mo" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Work Setup <span class="text-danger">*</span></label>
                            <select name="setup" class="form-select rounded-3" required>
                                @foreach(['On-site','Hybrid','Remote'] as $s)
                                <option value="{{ $s }}" {{ old('setup') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Duration <span class="text-danger">*</span></label>
                            <input type="text" name="duration" class="form-control rounded-3" value="{{ old('duration') }}" placeholder="e.g. 3 months" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small">Open Slots</label>
                            <input type="number" name="slots" class="form-control rounded-3" value="{{ old('slots', 1) }}" min="1">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Skills / Tags <span class="text-muted">(comma separated)</span></label>
                            <input type="text" name="tags" class="form-control rounded-3" value="{{ old('tags') }}" placeholder="e.g. HTML, CSS, JavaScript">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control rounded-3" rows="4" placeholder="Describe the internship..." required>{{ old('description') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Responsibilities <span class="text-muted">(one per line)</span></label>
                            <textarea name="responsibilities" class="form-control rounded-3" rows="4" placeholder="Build UI components&#10;Attend daily standups">{{ old('responsibilities') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Requirements <span class="text-muted">(one per line)</span></label>
                            <textarea name="requirements" class="form-control rounded-3" rows="4" placeholder="Currently enrolled in CS&#10;Knowledge of HTML/CSS">{{ old('requirements') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Benefits <span class="text-muted">(comma separated)</span></label>
                            <input type="text" name="benefits" class="form-control rounded-3" value="{{ old('benefits') }}" placeholder="e.g. Certificate, Mentorship, Transportation allowance">
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-success rounded-pill px-5 fw-semibold">
                            <i class="fas fa-paper-plane me-2"></i>Post Internship
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
