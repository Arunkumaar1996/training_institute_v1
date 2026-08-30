@extends('layouts.admin')

@section('title', 'Users & Staff Logins')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">System Users & Staff Logins</h3>
        <p class="text-muted small mb-0">Manage authorized administration, counselor, and trainer login accounts</p>
    </div>
    <button type="button" class="btn btn-primary rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
        <i class="bi bi-person-plus-fill me-1"></i> Add User Login
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">User</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Assigned Role</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary-subtle text-primary rounded-circle p-2 fs-5"><i class="bi bi-person"></i></div>
                                <strong class="text-dark">{{ $u->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->mobile ?: 'N/A' }}</td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $u->role_name }}</span></td>
                        <td>
                            <button class="btn btn-sm btn-{{ $u->status ? 'success' : 'secondary' }} rounded-pill px-2 py-0 toggle-user-status" data-id="{{ $u->id }}">
                                {{ $u->status ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td><small class="text-muted">{{ $u->last_login_at ? $u->last_login_at->diffForHumans() : 'Never' }}</small></td>
                        <td class="text-end pe-4">
                            @if($u->id !== auth()->id() && $u->id !== 1)
                                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete this user?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @else
                                <span class="badge bg-light text-muted border">System</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Create User Login</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="Full Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control rounded-3" required placeholder="user@institute.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mobile</label>
                        <input type="tel" name="mobile" class="form-control rounded-3" placeholder="10-digit mobile">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Assign Role <span class="text-danger">*</span></label>
                        <select name="role_id" class="form-select rounded-3" required>
                            @foreach($roles as $r)
                                <option value="{{ $r->id }}">{{ $r->name }} ({{ $r->slug }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control rounded-3" required minlength="6" placeholder="Min 6 characters">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.toggle-user-status').on('click', function() {
        const btn = $(this);
        const id = btn.data('id');
        $.post(`/admin/users/${id}/toggle-status`, {}, function(res) {
            if (res.success) {
                btn.toggleClass('btn-success btn-secondary').text(res.status ? 'Active' : 'Inactive');
            }
        });
    });
</script>
@endpush
