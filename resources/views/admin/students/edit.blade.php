@extends('layouts.admin')

@section('title', 'Edit Student: ' . $student->full_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Edit Student Record</h3>
        <p class="text-muted small mb-0">{{ $student->full_name }} ({{ $student->student_code }})</p>
    </div>
    <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> View Profile
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.students.update', $student->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Personal Info -->
        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Personal Details</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control rounded-3" value="{{ old('first_name', $student->first_name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Last Name</label>
                <input type="text" name="last_name" class="form-control rounded-3" value="{{ old('last_name', $student->last_name) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="active" {{ $student->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ $student->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="dropped" {{ $student->status === 'dropped' ? 'selected' : '' }}>Dropped</option>
                    <option value="suspended" {{ $student->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Date of Birth</label>
                <input type="date" name="dob" class="form-control rounded-3" value="{{ old('dob', $student->dob?->format('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Gender</label>
                <select name="gender" class="form-select rounded-3">
                    <option value="Male" {{ $student->gender === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $student->gender === 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ $student->gender === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Blood Group</label>
                <input type="text" name="blood_group" class="form-control rounded-3" value="{{ old('blood_group', $student->blood_group) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Update Photo</label>
                <input type="file" name="photo" class="form-control rounded-3" accept="image/*">
            </div>
        </div>

        <!-- Contact & Address -->
        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Contact Details</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                <input type="tel" name="mobile" class="form-control rounded-3" value="{{ old('mobile', $student->mobile) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Alternate Mobile</label>
                <input type="tel" name="alternate_mobile" class="form-control rounded-3" value="{{ old('alternate_mobile', $student->alternate_mobile) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $student->email) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Address Line</label>
                <input type="text" name="address" class="form-control rounded-3" value="{{ old('address', $student->address) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">City</label>
                <input type="text" name="city" class="form-control rounded-3" value="{{ old('city', $student->city) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">State</label>
                <input type="text" name="state" class="form-control rounded-3" value="{{ old('state', $student->state) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Pincode</label>
                <input type="text" name="pincode" class="form-control rounded-3" value="{{ old('pincode', $student->pincode) }}">
            </div>
        </div>

        <!-- Guardian & Education -->
        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Guardian & Education</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Parent / Guardian Name</label>
                <input type="text" name="parent_name" class="form-control rounded-3" value="{{ old('parent_name', $student->parent_name) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Parent Contact</label>
                <input type="tel" name="parent_mobile" class="form-control rounded-3" value="{{ old('parent_mobile', $student->parent_mobile) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Qualification</label>
                <input type="text" name="qualification" class="form-control rounded-3" value="{{ old('qualification', $student->qualification) }}">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Save Changes</button>
        </div>
    </form>
</div>
@endsection
