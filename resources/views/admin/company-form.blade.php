@extends('layouts.app')
@section('title', 'Add Company')

@section('content')

<div class="bg-dark text-white py-4">
    <div class="container">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
            <div>
                <h4 class="fw-bold mb-0"><i class="fas fa-building me-2 text-warning"></i>Add New Company</h4>
                <p class="mb-0 opacity-75 small">Admin only — CareerHub</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">

                @if($errors->any())
                <div class="alert alert-danger rounded-3 border-0 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.companies.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" value="{{ old('name') }}" placeholder="e.g. Google Philippines" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Industry <span class="text-danger">*</span></label>
                            <select name="industry" class="form-select rounded-3" required>
                                <option value="">Select Industry</option>
                                @foreach(['Technology','E-Commerce','Social Media','Entertainment','Finance','Healthcare','Education','Super App','Logistics','Other'] as $ind)
                                <option value="{{ $ind }}" {{ old('industry') === $ind ? 'selected' : '' }}>{{ $ind }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-warning rounded-pill px-5 fw-semibold">
                            <i class="fas fa-plus me-2"></i>Add Company
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
