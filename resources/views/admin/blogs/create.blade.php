@extends('layouts.admin')

@section('title', 'Create Blog Post')
@section('page-title', 'Create New Blog Post')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Blog Post Information</h5>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Category *</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->translation()?->name ?? $category->id }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Published Date</label>
                            <input type="date" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at') }}">
                            @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Slug *</label>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">URL-friendly version (e.g., my-blog-post)</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Featured Image</label>
                        <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                        @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Recommended size: 1200x630px (Max: 2MB)</small>
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3">English Content</h6>

                    <div class="mb-3">
                        <label class="form-label">Title (English) *</label>
                        <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror" value="{{ old('title_en') }}" required>
                        @error('title_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Excerpt (English) *</label>
                        <textarea name="excerpt_en" class="form-control @error('excerpt_en') is-invalid @enderror" rows="3" required>{{ old('excerpt_en') }}</textarea>
                        @error('excerpt_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Brief summary of the post</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Content (English) *</label>
                        <textarea name="content_en" class="form-control @error('content_en') is-invalid @enderror" rows="10" required>{{ old('content_en') }}</textarea>
                        @error('content_en')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3">Khmer Content</h6>

                    <div class="mb-3">
                        <label class="form-label">Title (Khmer) *</label>
                        <input type="text" name="title_km" class="form-control @error('title_km') is-invalid @enderror" value="{{ old('title_km') }}" required>
                        @error('title_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Excerpt (Khmer) *</label>
                        <textarea name="excerpt_km" class="form-control @error('excerpt_km') is-invalid @enderror" rows="3" required>{{ old('excerpt_km') }}</textarea>
                        @error('excerpt_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Content (Khmer) *</label>
                        <textarea name="content_km" class="form-control @error('content_km') is-invalid @enderror" rows="10" required>{{ old('content_km') }}</textarea>
                        @error('content_km')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="text-end mt-4">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-redo me-2"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Create Blog Post
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
