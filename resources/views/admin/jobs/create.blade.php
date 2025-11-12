@extends('layouts.admin')

@section('title', 'Create Job Position')
@section('page-title', 'Create New Job Position')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Job Position Information</h5>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jobs.store') }}" method="POST">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Slug *</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">URL-friendly (e.g., senior-developer)</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Department *</label>
                            <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ old('department') }}" required>
                            @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Location *</label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" required>
                            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Employment Type *</label>
                            <select name="employment_type" class="form-select @error('employment_type') is-invalid @enderror" required>
                                <option value="full-time" {{ old('employment_type') == 'full-time' ? 'selected' : '' }}>Full-Time</option>
                                <option value="part-time" {{ old('employment_type') == 'part-time' ? 'selected' : '' }}>Part-Time</option>
                                <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                            </select>
                            @error('employment_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Salary Range</label>
                            <input type="text" name="salary_range" class="form-control @error('salary_range') is-invalid @enderror" value="{{ old('salary_range') }}" placeholder="$1000 - $2000">
                            @error('salary_range')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Application Deadline</label>
                            <input type="date" name="application_deadline" class="form-control @error('application_deadline') is-invalid @enderror" value="{{ old('application_deadline') }}">
                            @error('application_deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3">English Content</h6>

                    <div class="mb-3">
                        <label class="form-label">Job Title (English) *</label>
                        <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}" required>
                        @error('title_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (English) *</label>
                        <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" rows="4" required>{{ old('description_en') }}</textarea>
                        @error('description_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Requirements (English) *</label>
                        <textarea name="requirements_en" class="form-control @error('requirements_en') is-invalid @enderror" rows="5" required>{{ old('requirements_en') }}</textarea>
                        @error('requirements_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">One requirement per line</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Responsibilities (English) *</label>
                        <textarea name="responsibilities_en" class="form-control @error('responsibilities_en') is-invalid @enderror" rows="5" required>{{ old('responsibilities_en') }}</textarea>
                        @error('responsibilities_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">One responsibility per line</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Benefits (English)</label>
                        <textarea name="benefits_en" class="form-control @error('benefits_en') is-invalid @enderror" rows="4">{{ old('benefits_en') }}</textarea>
                        @error('benefits_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3">Khmer Content</h6>

                    <div class="mb-3">
                        <label class="form-label">Job Title (Khmer) *</label>
                        <input type="text" name="title_km" class="form-control @error('title_km') is-invalid @enderror" value="{{ old('title_km') }}" required>
                        @error('title_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (Khmer) *</label>
                        <textarea name="description_km" class="form-control @error('description_km') is-invalid @enderror" rows="4" required>{{ old('description_km') }}</textarea>
                        @error('description_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Requirements (Khmer) *</label>
                        <textarea name="requirements_km" class="form-control @error('requirements_km') is-invalid @enderror" rows="5" required>{{ old('requirements_km') }}</textarea>
                        @error('requirements_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Responsibilities (Khmer) *</label>
                        <textarea name="responsibilities_km" class="form-control @error('responsibilities_km') is-invalid @enderror" rows="5" required>{{ old('responsibilities_km') }}</textarea>
                        @error('responsibilities_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Benefits (Khmer)</label>
                        <textarea name="benefits_km" class="form-control @error('benefits_km') is-invalid @enderror" rows="4">{{ old('benefits_km') }}</textarea>
                        @error('benefits_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end mt-4">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo me-2"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Job Position
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
