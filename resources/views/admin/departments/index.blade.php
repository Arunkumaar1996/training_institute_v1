@extends('layouts.admin')

@section('title', 'Departments Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Institute Departments</h3>
        <p class="text-muted small mb-0">Organize institute administrative and technical divisions</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createDeptModal">
        <i class="bi bi-plus-circle me-1"></i> Add Department
    </button>
</div>

<!-- Departments Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Department Name</th>
                    <th>Staff Count</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $dept->name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $dept->employees_count }} Staff Members</span></td>
                        <td>
                            <span class="badge bg-{{ $dept->status ? 'success' : 'secondary' }} badge-chip">
                                {{ $dept->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <form method="POST" action="{{ route('admin.departments.destroy', $dept->id) }}" onsubmit="return confirm('Delete this department?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No departments created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create Department Modal -->
<div class="modal fade" id="createDeptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Add Department</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.departments.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Department Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="e.g. Accounts & Finance, Technical Labs">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control rounded-3" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Create Department</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
