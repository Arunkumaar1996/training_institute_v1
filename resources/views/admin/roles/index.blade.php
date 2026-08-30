@extends('layouts.admin')

@section('title', 'Roles & RBAC Access Control')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Roles & Access Control (RBAC)</h3>
        <p class="text-muted small mb-0">Manage security permission matrix for Super Admin, Admin, Counselor, Accountant, and Trainer</p>
    </div>
</div>

<div class="row g-4">
    @foreach($roles as $r)
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">{{ $r->name }}</h5>
                        <span class="badge bg-primary-subtle text-primary">{{ $r->slug }}</span>
                    </div>
                    <span class="badge bg-light text-dark border">{{ $r->users_count }} Assigned Users</span>
                </div>
                <p class="text-muted small mb-3">{{ $r->description }}</p>

                <!-- Update Permissions Form -->
                <form method="POST" action="{{ route('admin.roles.permissions.update', $r->id) }}">
                    @csrf
                    <h6 class="fw-bold text-primary small mb-2">Assigned Module Permissions:</h6>
                    <div class="row g-2 mb-3" style="max-height: 220px; overflow-y: auto;">
                        @foreach($permissions as $perm)
                            <div class="col-sm-6">
                                <div class="form-check small">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm_{{ $r->id }}_{{ $perm->id }}" {{ $r->permissions->contains($perm->id) ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark" for="perm_{{ $r->id }}_{{ $perm->id }}">
                                        {{ $perm->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Update Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
