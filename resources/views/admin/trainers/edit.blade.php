@extends('layouts.admin')

@section('title', 'Edit Trainer: ' . $trainer->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Edit Trainer: {{ $trainer->name }}</h3>
        <p class="text-muted small mb-0">{{ $trainer->specialization }}</p>
    </div>
    <a href="{{ route('admin.trainers.show', $trainer->id) }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.trainers.update', $trainer->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Trainer Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $trainer->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Specialization <span class="text-danger">*</span></label>
                <input type="text" name="specialization" class="form-control rounded-3" value="{{ old('specialization', $trainer->specialization) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Mobile <span class="text-danger">*</span></label>
                <input type="tel" name="mobile" class="form-control rounded-3" value="{{ old('mobile', $trainer->mobile) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control rounded-3" value="{{ old('email', $trainer->email) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Experience (Years)</label>
                <input type="number" name="experience_years" class="form-control rounded-3" value="{{ old('experience_years', $trainer->experience_years) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Qualification</label>
                <input type="text" name="qualification" class="form-control rounded-3" value="{{ old('qualification', $trainer->qualification) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Technical Skills</label>
                <input type="text" name="skills" class="form-control rounded-3" value="{{ old('skills', $trainer->skills) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Update Photo</label>
                <input type="file" name="photo" class="form-control rounded-3" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="1" {{ $trainer->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$trainer->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Biography</label>
                <textarea name="bio" class="form-control rounded-3" rows="4">{{ old('bio', $trainer->bio) }}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.trainers.show', $trainer->id) }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Save Changes</button>
        </div>
    </form>
</div>
@endsection
