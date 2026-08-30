@extends('layouts.admin')

@section('title', 'Courses Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Course Management</h3>
        <p class="text-muted small mb-0">Manage training programs, syllabus modules, fee pricing, and featured courses</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Add New Course
    </a>
</div>

<!-- Filter Form -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.courses.index') }}">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light" value="{{ request('search') }}" placeholder="Search course by name, code...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="category_id" class="form-select bg-light">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select bg-light">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill"></i></button>
            </div>
        </div>
    </form>
</div>

<!-- Courses Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Course</th>
                    <th>Category</th>
                    <th>Level & Duration</th>
                    <th>Fees</th>
                    <th>Batches</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $course->image ?: 'https://images.unsplash.com/photo-1597740985671-2a8a3b80532e?auto=format&fit=crop&w=150&q=80' }}" class="rounded-3 object-fit-cover shadow-sm" style="width: 48px; height: 48px;" alt="{{ $course->course_name }}">
                                <div>
                                    <a href="{{ route('admin.courses.show', $course->id) }}" class="fw-bold text-dark text-decoration-none d-block">{{ $course->course_name }}</a>
                                    <span class="badge bg-light text-muted border text-xs">{{ $course->course_code }}</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $course->category?->name ?? 'General' }}</span></td>
                        <td>
                            <div class="small">
                                <div class="fw-semibold text-dark">{{ $course->level }}</div>
                                <span class="text-muted">{{ $course->duration }} {{ $course->duration_unit }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <div class="fw-bold text-primary">₹{{ number_format($course->final_fee) }}</div>
                                @if($course->discount_fee > 0)
                                    <span class="text-muted text-decoration-line-through text-xs">₹{{ number_format($course->course_fee) }}</span>
                                @endif
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $course->batches_count }} Batches</span></td>
                        <td>
                            <button class="btn btn-sm btn-{{ $course->featured ? 'warning' : 'outline-secondary' }} rounded-pill px-2 py-0 toggle-featured" data-id="{{ $course->id }}">
                                <i class="bi bi-star{{ $course->featured ? '-fill' : '' }}"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-{{ $course->status === 'active' ? 'success' : 'secondary' }} rounded-pill px-2 py-0 toggle-status" data-id="{{ $course->id }}">
                                {{ ucfirst($course->status) }}
                            </button>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-outline-primary" title="View & Manage Syllabus"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-outline-secondary" title="Edit Course"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('admin.courses.destroy', $course->id) }}" onsubmit="return confirm('Delete this course?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No courses registered yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $courses->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.toggle-featured').on('click', function() {
        const btn = $(this);
        const id = btn.data('id');
        $.post(`/admin/courses/${id}/toggle-featured`, {}, function(res) {
            if (res.success) {
                btn.toggleClass('btn-warning btn-outline-secondary')
                   .find('i').toggleClass('bi-star-fill bi-star');
            }
        });
    });

    $('.toggle-status').on('click', function() {
        const btn = $(this);
        const id = btn.data('id');
        $.post(`/admin/courses/${id}/toggle-status`, {}, function(res) {
            if (res.success) {
                btn.toggleClass('btn-success btn-secondary')
                   .text(res.status === 'active' ? 'Active' : 'Inactive');
            }
        });
    });
</script>
@endpush
