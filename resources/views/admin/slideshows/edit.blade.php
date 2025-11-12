@extends('layouts.admin')

@section('title', 'Edit Slideshow')
@section('page-title', 'Edit Slideshow')

@section('content')
@php
    $enTranslation = $slideshow->translations->where('language.code', 'en')->first();
    $kmTranslation = $slideshow->translations->where('language.code', 'km')->first();
@endphp

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Slideshow</h5>
                <a href="{{ route('admin.slideshows.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.slideshows.update', $slideshow) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Order *</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $slideshow->order) }}" required>
                            @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $slideshow->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $slideshow->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Link URL</label>
                            <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $slideshow->link) }}">
                            @error('link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Slide Image</label>
                        @if($slideshow->image)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/slideshows/' . $slideshow->image) }}" alt="Current" style="max-width: 300px; border-radius: 8px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3">English Content</h6>

                    <div class="mb-3">
                        <label class="form-label">Title (English) *</label>
                        <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en', $enTranslation?->title) }}" required>
                        @error('title_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror" rows="3">{{ old('description_en', $enTranslation?->description) }}</textarea>
                        @error('description_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3">Khmer Content</h6>

                    <div class="mb-3">
                        <label class="form-label">Title (Khmer) *</label>
                        <input type="text" name="title_km" class="form-control @error('title_km') is-invalid @enderror" value="{{ old('title_km', $kmTranslation?->title) }}" required>
                        @error('title_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description (Khmer)</label>
                        <textarea name="description_km" class="form-control @error('description_km') is-invalid @enderror" rows="3">{{ old('description_km', $kmTranslation?->description) }}</textarea>
                        @error('description_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Slideshow
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
