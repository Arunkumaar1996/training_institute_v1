@extends('layouts.admin')

@section('title', 'Edit Employee: ' . $employee->full_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Edit Employee: {{ $employee->full_name }}</h3>
        <p class="text-muted small mb-0">{{ $employee->employee_code }}</p>
    </div>
    <a href="{{ route('admin.employees.show', $employee->id) }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> View Profile
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.employees.update', $employee->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Personal Details</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control rounded-3" value="{{ old('first_name', $employee->first_name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Last Name</label>
                <input type="text" name="last_name" class="form-control rounded-3" value="{{ old('last_name', $employee->last_name) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Gender</label>
                <select name="gender" class="form-select rounded-3">
                    <option value="Male" {{ $employee->gender === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $employee->gender === 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Mobile <span class="text-danger">*</span></label>
                <input type="tel" name="mobile" class="form-control rounded-3" value="{{ old('mobile', $employee->mobile) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $employee->email) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="active" {{ $employee->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $employee->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="resigned" {{ $employee->status === 'resigned' ? 'selected' : '' }}>Resigned</option>
                </select>
            </div>
        </div>

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Employment & Role</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Department <span class="text-danger">*</span></label>
                <select name="department_id" class="form-select rounded-3" required>
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}" {{ $employee->department_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Designation</label>
                <select name="designation_id" class="form-select rounded-3">
                    <option value="">-- Choose Designation --</option>
                    @foreach($designations as $ds)
                        <option value="{{ $ds->id }}" {{ $employee->designation_id == $ds->id ? 'selected' : '' }}>{{ $ds->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Basic Monthly Salary (₹)</label>
                <input type="number" name="basic_salary" class="form-control rounded-3" value="{{ old('basic_salary', $employee->basic_salary) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Update Photo</label>
                <input type="file" name="photo" class="form-control rounded-3" accept="image/*">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.employees.show', $employee->id) }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Save Changes</button>
        </div>
    </form>
</div>
@endsection
