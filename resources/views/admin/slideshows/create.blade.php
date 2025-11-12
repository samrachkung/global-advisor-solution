@extends('layouts.admin')

@section('title', 'Create Slideshow')
@section('page-title', 'Create New Slideshow')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Slideshow Information</h5>
                <a href="{{ route('admin.slideshows.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.slideshows.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Order *</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 1) }}" required>
                            @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Link URL</label>
                            <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="https://example.com">
                            @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Slide Image *</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Recommended size: 1920x800px (Max: 2MB)</small>
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3">English Content</h6>

                    <div class="mb-3">
                        <label class="form-label">Title (English) *</label>
                        <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}" required>
                        @error('title_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" rows="3">{{ old('description_en') }}</textarea>
                        @error('description_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Button Text (English)</label>
                        <input type="text" name="button_text_en" class="form-control @error('button_text_en') is-invalid @enderror" value="{{ old('button_text_en') }}" placeholder="Learn More">
                        @error('button_text_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3">Khmer Content</h6>

                    <div class="mb-3">
                        <label class="form-label">Title (Khmer) *</label>
                        <input type="text" name="title_km" class="form-control @error('title_km') is-invalid @enderror" value="{{ old('title_km') }}" required>
                        @error('title_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (Khmer)</label>
                        <textarea name="description_km" class="form-control @error('description_km') is-invalid @enderror" rows="3">{{ old('description_km') }}</textarea>
                        @error('description_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Button Text (Khmer)</label>
                        <input type="text" name="button_text_km" class="form-control @error('button_text_km') is-invalid @enderror" value="{{ old('button_text_km') }}">
                        @error('button_text_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end mt-4">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo me-2"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Slideshow
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
