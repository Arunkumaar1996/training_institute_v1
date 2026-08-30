@extends('layouts.admin')

@section('title', 'Edit Article: ' . $blog->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Edit Article</h3>
        <p class="text-muted small mb-0">{{ $blog->title }}</p>
    </div>
    <a href="{{ route('admin.cms.blogs') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.cms.blogs.update', $blog->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <label class="form-label fw-semibold">Article Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control rounded-3" value="{{ old('title', $blog->title) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Category</label>
                <select name="category_id" class="form-select rounded-3">
                    <option value="">-- Choose Category --</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ $blog->category_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Excerpt</label>
                <textarea name="excerpt" class="form-control rounded-3" rows="2">{{ old('excerpt', $blog->excerpt) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Article Content <span class="text-danger">*</span></label>
                <textarea name="content" class="form-control rounded-3" rows="10" required>{{ old('content', $blog->content) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Update Featured Image</label>
                <input type="file" name="featured_image" class="form-control rounded-3" accept="image/*">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="published" {{ $blog->status === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ $blog->status === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tags</label>
                <input type="text" name="tags" class="form-control rounded-3" value="{{ old('tags', $blog->tags) }}">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.cms.blogs') }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Save Changes</button>
        </div>
    </form>
</div>
@endsection
