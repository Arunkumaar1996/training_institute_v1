@extends('layouts.admin')

@section('title', 'Add New Employee')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Register New Staff Member</h3>
        <p class="text-muted small mb-0">Add personal, department, designation, and salary information</p>
    </div>
    <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.employees.store') }}" enctype="multipart/form-data">
        @csrf

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Personal Details</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control rounded-3" value="{{ old('first_name') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Last Name</label>
                <input type="text" name="last_name" class="form-control rounded-3" value="{{ old('last_name') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Gender</label>
                <select name="gender" class="form-select rounded-3">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Date of Birth</label>
                <input type="date" name="dob" class="form-control rounded-3">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Mobile <span class="text-danger">*</span></label>
                <input type="tel" name="mobile" class="form-control rounded-3" value="{{ old('mobile') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}">
            </div>
        </div>

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Employment & Department</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Department <span class="text-danger">*</span></label>
                <select name="department_id" class="form-select rounded-3" required>
                    <option value="">-- Choose Department --</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Designation</label>
                <select name="designation_id" class="form-select rounded-3">
                    <option value="">-- Select Designation --</option>
                    @foreach($designations as $ds)
                        <option value="{{ $ds->id }}">{{ $ds->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Joining Date <span class="text-danger">*</span></label>
                <input type="date" name="joining_date" class="form-control rounded-3" value="{{ old('joining_date', now()->toDateString()) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Basic Monthly Salary (₹)</label>
                <input type="number" name="basic_salary" class="form-control rounded-3" value="{{ old('basic_salary', 25000) }}" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Profile Photo</label>
                <input type="file" name="photo" class="form-control rounded-3" accept="image/*">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Save Employee</button>
        </div>
    </form>
</div>
@endsection
