@extends('layouts.admin')

@section('title', 'Edit Loan Type')
@section('page-title', 'Edit Loan Type')

@section('content')
@php
    $enTranslation = $loanType->translations->where('language.code', 'en')->first();
    $kmTranslation = $loanType->translations->where('language.code', 'km')->first();
    $cond = $loanType->conditions;
@endphp

<div class="row">
  <div class="col-lg-10 mx-auto">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Edit: {{ $enTranslation?->title }}</h5>
        <a href="{{ route('admin.loan-types.index') }}" class="btn btn-sm btn-secondary">
          <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
      </div>

      <div class="card-body">
        <form action="{{ route('admin.loan-types.update', $loanType) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row mb-4">
            <div class="col-md-6">
              <label class="form-label">Slug *</label>
              <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                     value="{{ old('slug', $loanType->slug) }}" required>
              @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3">
              <label class="form-label">Icon Class *</label>
              <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                     value="{{ old('icon', $loanType->icon) }}" required>
              @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <small class="text-muted">e.g., fas fa-seedling</small>
            </div>
            <div class="col-md-3">
              <label class="form-label">Poster Image</label>
              <input type="file" name="poster" class="form-control @error('poster') is-invalid @enderror" accept="image/*">
              @error('poster')<div class="invalid-feedback">{{ $message }}</div>@enderror
              @if ($loanType->poster)
                <div class="mt-2">
                  <img src="{{ asset('uploads/services/' . $loanType->poster) }}" alt="Poster"
                       class="rounded border" style="width:160px;height:80px;object-fit:cover;">
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="poster_remove" value="1" id="posterRemove">
                    <label class="form-check-label" for="posterRemove">Remove poster</label>
                  </div>
                </div>
              @endif
              <small class="text-muted d-block">Recommended 1200×600px, JPG/PNG</small>
            </div>

            <div class="col-md-2 mt-3">
              <label class="form-label">Order *</label>
              <input type="number" name="order" class="form-control @error('order') is-invalid @enderror"
                     value="{{ old('order', $loanType->order) }}" required>
              @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-1 mt-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="active"  {{ old('status', $loanType->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive"{{ old('status', $loanType->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
            </div>
          </div>

          <hr class="my-4">
          <h6 class="mb-3">English Translation</h6>

          <div class="mb-3">
            <label class="form-label">Title (English) *</label>
            <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror"
                   value="{{ old('title_en', $enTranslation?->title) }}" required>
            @error('title_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Description (English) *</label>
            <textarea name="description_en" rows="4" class="form-control @error('description_en') is-invalid @enderror" required>{{ old('description_en', $enTranslation?->description) }}</textarea>
            @error('description_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Conditions (English)</label>
            <textarea name="conditions_en" rows="3" class="form-control @error('conditions_en') is-invalid @enderror">{{ old('conditions_en', $enTranslation?->conditions) }}</textarea>
            @error('conditions_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <hr class="my-4">
          <h6 class="mb-3">Khmer Translation</h6>

          <div class="mb-3">
            <label class="form-label">Title (Khmer) *</label>
            <input type="text" name="title_km" class="form-control @error('title_km') is-invalid @enderror"
                   value="{{ old('title_km', $kmTranslation?->title) }}" required>
            @error('title_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Description (Khmer) *</label>
            <textarea name="description_km" rows="4" class="form-control @error('description_km') is-invalid @enderror" required>{{ old('description_km', $kmTranslation?->description) }}</textarea>
            @error('description_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Conditions (Khmer)</label>
            <textarea name="conditions_km" rows="3" class="form-control @error('conditions_km') is-invalid @enderror">{{ old('conditions_km', $kmTranslation?->conditions) }}</textarea>
            @error('conditions_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <hr class="my-4">
          <h6 class="mb-3">Loan Conditions</h6>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Currency Type</label>
              <select name="currency_type" class="form-select @error('currency_type') is-invalid @enderror">
                <option value="">— Keep current —</option>
                <option value="USD"  {{ old('currency_type', $cond?->currency_type) == 'USD' ? 'selected' : '' }}>USD Only</option>
                <option value="KHR"  {{ old('currency_type', $cond?->currency_type) == 'KHR' ? 'selected' : '' }}>KHR Only</option>
                <option value="Both" {{ old('currency_type', $cond?->currency_type) == 'Both' ? 'selected' : '' }}>Both USD & KHR</option>
              </select>
              @error('currency_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Min Amount</label>
              <input type="number" step="0.01" name="min_amount" class="form-control @error('min_amount') is-invalid @enderror"
                     value="{{ old('min_amount', $cond?->min_amount) }}">
              @error('min_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Max Amount</label>
              <input type="number" step="0.01" name="max_amount" class="form-control @error('max_amount') is-invalid @enderror"
                     value="{{ old('max_amount', $cond?->max_amount) }}">
              @error('max_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Max Duration (Months)</label>
              <input type="number" name="max_duration_months" class="form-control @error('max_duration_months') is-invalid @enderror"
                     value="{{ old('max_duration_months', $cond?->max_duration_months) }}">
              @error('max_duration_months')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Min Age</label>
              <input type="number" name="min_age" class="form-control @error('min_age') is-invalid @enderror"
                     value="{{ old('min_age', $cond?->min_age) }}">
              @error('min_age')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Max Age</label>
              <input type="number" name="max_age" class="form-control @error('max_age') is-invalid @enderror"
                     value="{{ old('max_age', $cond?->max_age) }}">
              @error('max_age')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Max Debt Ratio (%)</label>
              <input type="number" step="0.01" name="max_debt_ratio" class="form-control @error('max_debt_ratio') is-invalid @enderror"
                     value="{{ old('max_debt_ratio', $cond?->max_debt_ratio) }}">
              @error('max_debt_ratio')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
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
