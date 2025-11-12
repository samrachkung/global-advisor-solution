@extends('layouts.admin')

@section('title', 'Edit Loan Type')
@section('page-title', 'Edit Loan Type')

@section('content')
    @php
        $enTranslation = $loanType->translations->where('language.code', 'en')->first();
        $kmTranslation = $loanType->translations->where('language.code', 'km')->first();
    @endphp

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Edit: {{ $enTranslation?->title }}</h5>
                    <a href="{{ route('admin.loan-types.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.loan-types.update', $loanType) }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Slug *</label>
                                <input type="text" name="slug"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $loanType->slug) }}" required>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Icon Class *</label>
                                <input type="text" name="icon"
                                    class="form-control @error('icon') is-invalid @enderror"
                                    value="{{ old('icon', $loanType->icon) }}" required>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Poster Image</label>
                                <input type="file" name="poster"
                                    class="form-control @error('poster') is-invalid @enderror" accept="image/*">
                                @error('poster')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($loanType->poster)
                                    <div class="mt-2">
                                        <img src="{{ asset('uploads/services/' . $loanType->poster) }}" alt="Poster"
                                            class="rounded border" style="width: 160px; height: 80px; object-fit: cover;">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="poster_remove"
                                                value="1" id="posterRemove">
                                            <label class="form-check-label" for="posterRemove">Remove poster</label>
                                        </div>
                                    </div>
                                @endif
                                <small class="text-muted d-block">Recommended 1200×600px, JPG/PNG</small>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Order *</label>
                                <input type="number" name="order"
                                    class="form-control @error('order') is-invalid @enderror"
                                    value="{{ old('order', $loanType->order) }}" required>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active"
                                        {{ old('status', $loanType->status) == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive"
                                        {{ old('status', $loanType->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3">English Translation</h6>

                        <div class="mb-3">
                            <label class="form-label">Title (English) *</label>
                            <input type="text" name="title_en"
                                class="form-control @error('title_en') is-invalid @enderror"
                                value="{{ old('title_en', $enTranslation?->title) }}" required>
                            @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description (English) *</label>
                            <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" rows="4"
                                required>{{ old('description_en', $enTranslation?->description) }}</textarea>
                            @error('description_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3">Khmer Translation</h6>

                        <div class="mb-3">
                            <label class="form-label">Title (Khmer) *</label>
                            <input type="text" name="title_km"
                                class="form-control @error('title_km') is-invalid @enderror"
                                value="{{ old('title_km', $kmTranslation?->title) }}" required>
                            @error('title_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description (Khmer) *</label>
                            <textarea name="description_km" class="form-control @error('description_km') is-invalid @enderror" rows="4"
                                required>{{ old('description_km', $kmTranslation?->description) }}</textarea>
                            @error('description_km')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Loan Type
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
