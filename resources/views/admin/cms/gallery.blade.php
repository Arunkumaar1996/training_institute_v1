@extends('layouts.admin')

@section('title', 'Manage Photo Gallery')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Lab & Campus Gallery</h3>
        <p class="text-muted small mb-0">Upload and categorize photos of training labs, microscope stations, and events</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#uploadImageModal">
        <i class="bi bi-upload me-1"></i> Upload Photo
    </button>
</div>

<div class="row g-4">
    @forelse($images as $img)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <img src="{{ $img->image_path ?: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=400&q=80' }}" class="card-img-top object-fit-cover" style="height: 180px;" alt="{{ $img->title }}">
                <div class="card-body p-3 d-flex flex-column">
                    <h6 class="fw-bold text-dark mb-1">{{ $img->title }}</h6>
                    <small class="text-muted mb-2 flex-grow-1">{{ $img->category?->name ?? 'General' }}</small>
                    <div class="text-end border-top pt-2">
                        <form method="POST" action="{{ route('admin.cms.gallery.destroy', $img->id) }}" onsubmit="return confirm('Delete this image?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">No images in gallery.</div>
    @endforelse
</div>

<!-- Modal -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Upload Gallery Image</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.cms.gallery.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control rounded-3" required placeholder="e.g. Micro-soldering Laboratory Session">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="category_id" class="form-select rounded-3">
                            <option value="">-- Choose Gallery Category --</option>
                            @foreach($categories as $gCat)
                                <option value="{{ $gCat->id }}">{{ $gCat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Image File <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control rounded-3" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control rounded-3" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Upload Photo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
