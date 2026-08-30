@extends('layouts.admin')

@section('title', 'Manage Testimonials & Reviews')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Student Reviews & Testimonials</h3>
        <p class="text-muted small mb-0">Display verified student alumni feedback on website homepage and reviews section</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createTestimonialModal">
        <i class="bi bi-plus-circle me-1"></i> Add Testimonial
    </button>
</div>

<div class="row g-4">
    @forelse($testimonials as $t)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ $t->photo ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80' }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 50px; height: 50px;" alt="{{ $t->name }}">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">{{ $t->name }}</h6>
                        <small class="text-muted">{{ $t->designation ?: 'Alumni Student' }}</small>
                    </div>
                </div>
                <div class="text-warning mb-2">
                    @for($s = 0; $s < $t->rating; $s++) <i class="bi bi-star-fill"></i> @endfor
                </div>
                <p class="text-muted small flex-grow-1">"{{ $t->review }}"</p>
                <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                    <span class="badge bg-{{ $t->status ? 'success' : 'secondary' }} badge-chip">{{ $t->status ? 'Active' : 'Hidden' }}</span>
                    <form method="POST" action="{{ route('admin.cms.testimonials.destroy', $t->id) }}" onsubmit="return confirm('Delete review?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">No testimonials added yet.</div>
    @endforelse
</div>

<!-- Modal -->
<div class="modal fade" id="createTestimonialModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Add Testimonial</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.cms.testimonials.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Student Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="e.g. Ramesh Kumar">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Designation / Shop Name</label>
                        <input type="text" name="designation" class="form-control rounded-3" placeholder="e.g. Owner, iFix Mobile Solutions">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Rating</label>
                        <select name="rating" class="form-select rounded-3">
                            <option value="5" selected>5 Stars (★★★★★)</option>
                            <option value="4">4 Stars (★★★★☆)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Photo</label>
                        <input type="file" name="photo" class="form-control rounded-3" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Review Text <span class="text-danger">*</span></label>
                        <textarea name="review" class="form-control rounded-3" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Save Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
