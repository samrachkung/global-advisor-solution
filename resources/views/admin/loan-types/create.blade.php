@extends('layouts.admin')

@section('title', 'Create Loan Type')
@section('page-title', 'Create New Loan Type')

@section('content')
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Loan Type Information</h5>
                    <a href="{{ route('admin.loan-types.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.loan-types.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Slug *</label>
                                <input type="text" name="slug"
                                    class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                                    required>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Icon Class *</label>
                                <input type="text" name="icon"
                                    class="form-control @error('icon') is-invalid @enderror"
                                    value="{{ old('icon', 'fas fa-hand-holding-usd') }}" required>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">e.g., fas fa-seedling</small>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Poster Image</label>
                                <input type="file" name="poster"
                                    class="form-control @error('poster') is-invalid @enderror" accept="image/*">
                                @error('poster')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block">Recommended 1280×1280px, JPG/PNG (square), up to 3MB</small>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Order *</label>
                                <input type="number" name="order"
                                    class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 1) }}"
                                    required>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3">English Translation</h6>

                        <div class="mb-3">
                            <label class="form-label">Title (English) *</label>
                            <input type="text" name="title_en"
                                class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}"
                                required>
                            @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description (English) *</label>
                            <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" rows="4"
                                required>{{ old('description_en') }}</textarea>
                            @error('description_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Conditions (English)</label>
                            <textarea name="conditions_en" class="form-control @error('conditions_en') is-invalid @enderror" rows="4">{{ old('conditions_en') }}</textarea>
                            @error('conditions_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3">Khmer Translation</h6>

                        <div class="mb-3">
                            <label class="form-label">Title (Khmer) *</label>
                            <input type="text" name="title_km"
                                class="form-control @error('title_km') is-invalid @enderror" value="{{ old('title_km') }}"
                                required>
                            @error('title_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description (Khmer) *</label>
                            <textarea name="description_km" class="form-control @error('description_km') is-invalid @enderror" rows="4"
                                required>{{ old('description_km') }}</textarea>
                            @error('description_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Conditions (Khmer)</label>
                            <textarea name="conditions_km" class="form-control @error('conditions_km') is-invalid @enderror" rows="4">{{ old('conditions_km') }}</textarea>
                            @error('conditions_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3">Loan Conditions</h6>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Currency Type *</label>
                                <select name="currency_type"
                                    class="form-select @error('currency_type') is-invalid @enderror" required>
                                    <option value="USD">USD Only</option>
                                    <option value="KHR">KHR Only</option>
                                    <option value="Both" selected>Both USD & KHR</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Min Amount *</label>
                                <input type="number" step="0.01" name="min_amount"
                                    class="form-control @error('min_amount') is-invalid @enderror"
                                    value="{{ old('min_amount', 100) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Amount *</label>
                                <input type="number" step="0.01" name="max_amount"
                                    class="form-control @error('max_amount') is-invalid @enderror"
                                    value="{{ old('max_amount', 50000) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Duration (Months) *</label>
                                <input type="number" name="max_duration_months"
                                    class="form-control @error('max_duration_months') is-invalid @enderror"
                                    value="{{ old('max_duration_months', 96) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Min Age *</label>
                                <input type="number" name="min_age"
                                    class="form-control @error('min_age') is-invalid @enderror"
                                    value="{{ old('min_age', 18) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Age *</label>
                                <input type="number" name="max_age"
                                    class="form-control @error('max_age') is-invalid @enderror"
                                    value="{{ old('max_age', 65) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Debt Ratio (%) *</label>
                                <input type="number" step="0.01" name="max_debt_ratio"
                                    class="form-control @error('max_debt_ratio') is-invalid @enderror"
                                    value="{{ old('max_debt_ratio', 70) }}" required>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-redo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Loan Type
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
