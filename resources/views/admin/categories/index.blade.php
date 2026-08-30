@extends('layouts.admin')

@section('title', 'Course Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Course Categories</h3>
        <p class="text-muted small mb-0">Manage training domains (Mobile Hardware, Software, Laptop Chip Level, etc.)</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createCatModal">
        <i class="bi bi-plus-circle me-1"></i> Add Category
    </button>
</div>

<!-- Categories Table Card -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Icon / Image</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Active Courses</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td class="ps-4">
                            <div class="bg-primary-subtle text-primary rounded-3 d-flex align-items-center justify-content-center p-2" style="width: 40px; height: 40px;">
                                <i class="bi {{ $cat->icon ?: 'bi-cpu-fill' }} fs-5"></i>
                            </div>
                        </td>
                        <td class="fw-bold text-dark">{{ $cat->name }}</td>
                        <td><code>{{ $cat->slug }}</code></td>
                        <td><span class="badge bg-light text-dark border">{{ $cat->courses_count }} Courses</span></td>
                        <td>
                            <button class="btn btn-sm btn-{{ $cat->status ? 'success' : 'secondary' }} rounded-pill px-2 py-0 toggle-cat-status" data-id="{{ $cat->id }}">
                                {{ $cat->status ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="text-end pe-4">
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" onsubmit="return confirm('Delete this category?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No categories created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Category Modal -->
<div class="modal fade" id="createCatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Create Course Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="e.g. Mobile Chip Level">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Bootstrap Icon Class</label>
                        <input type="text" name="icon" class="form-control rounded-3" placeholder="e.g. bi-cpu, bi-phone, bi-laptop">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control rounded-3" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.toggle-cat-status').on('click', function() {
        const btn = $(this);
        const catId = btn.data('id');
        $.post(`/admin/categories/${catId}/toggle-status`, {}, function(res) {
            if (res.success) {
                btn.toggleClass('btn-success btn-secondary')
                   .text(res.status ? 'Active' : 'Inactive');
            }
        });
    });
</script>
@endpush
