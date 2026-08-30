@extends('layouts.admin')

@section('title', 'Register New Student')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Register New Student</h3>
        <p class="text-muted small mb-0">Add personal, contact, guardian and educational details</p>
    </div>
    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Students
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Personal Info -->
        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2"><i class="bi bi-person-fill me-2"></i> Personal Details</h5>
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
                <label class="form-label fw-semibold">Date of Birth</label>
                <input type="date" name="dob" class="form-control rounded-3" value="{{ old('dob') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Gender</label>
                <select name="gender" class="form-select rounded-3">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Blood Group</label>
                <input type="text" name="blood_group" class="form-control rounded-3" value="{{ old('blood_group') }}" placeholder="O+, B+, A+...">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Profile Photo</label>
                <input type="file" name="photo" class="form-control rounded-3" accept="image/*">
            </div>
        </div>

        <!-- Contact & Address -->
        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2"><i class="bi bi-telephone-fill me-2"></i> Contact & Address</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                <input type="tel" name="mobile" class="form-control rounded-3" value="{{ old('mobile') }}" required placeholder="10-digit number">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Alternate Mobile</label>
                <input type="tel" name="alternate_mobile" class="form-control rounded-3" value="{{ old('alternate_mobile') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Address Line</label>
                <input type="text" name="address" class="form-control rounded-3" value="{{ old('address') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">City</label>
                <input type="text" name="city" class="form-control rounded-3" value="{{ old('city') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">State</label>
                <input type="text" name="state" class="form-control rounded-3" value="{{ old('state', 'Tamil Nadu') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Pincode</label>
                <input type="text" name="pincode" class="form-control rounded-3" value="{{ old('pincode') }}">
            </div>
        </div>

        <!-- Guardian & Education -->
        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2"><i class="bi bi-mortarboard-fill me-2"></i> Guardian & Education</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Parent / Guardian Name</label>
                <input type="text" name="parent_name" class="form-control rounded-3" value="{{ old('parent_name') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Parent Contact Number</label>
                <input type="tel" name="parent_mobile" class="form-control rounded-3" value="{{ old('parent_mobile') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Highest Qualification</label>
                <input type="text" name="qualification" class="form-control rounded-3" value="{{ old('qualification') }}" placeholder="10th, 12th, ITI, Diploma, BE...">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">
                <i class="bi bi-check-circle me-1"></i> Register Student
            </button>
        </div>
    </form>
</div>
@endsection
