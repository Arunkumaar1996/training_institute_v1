@extends('layouts.admin')

@section('title', 'Edit Course: ' . $course->course_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Edit Course: {{ $course->course_name }}</h3>
        <p class="text-muted small mb-0">Code: {{ $course->course_code }}</p>
    </div>
    <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> View Course
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.courses.update', $course->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Basic Course Information</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Course Name <span class="text-danger">*</span></label>
                <input type="text" name="course_name" class="form-control rounded-3" value="{{ old('course_name', $course->course_name) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Course Code <span class="text-danger">*</span></label>
                <input type="text" name="course_code" class="form-control rounded-3" value="{{ old('course_code', $course->course_code) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Category</label>
                <select name="category_id" class="form-select rounded-3">
                    <option value="">-- Choose Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $course->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Skill Level</label>
                <select name="level" class="form-select rounded-3">
                    <option value="Basic" {{ $course->level === 'Basic' ? 'selected' : '' }}>Basic</option>
                    <option value="Intermediate" {{ $course->level === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="Advanced" {{ $course->level === 'Advanced' ? 'selected' : '' }}>Advanced</option>
                    <option value="Basic to Advanced" {{ $course->level === 'Basic to Advanced' ? 'selected' : '' }}>Basic to Advanced</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Duration (Number) <span class="text-danger">*</span></label>
                <input type="number" name="duration" class="form-control rounded-3" value="{{ old('duration', $course->duration) }}" required min="1">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Duration Unit</label>
                <select name="duration_unit" class="form-select rounded-3">
                    <option value="Days" {{ $course->duration_unit === 'Days' ? 'selected' : '' }}>Days</option>
                    <option value="Weeks" {{ $course->duration_unit === 'Weeks' ? 'selected' : '' }}>Weeks</option>
                    <option value="Months" {{ $course->duration_unit === 'Months' ? 'selected' : '' }}>Months</option>
                    <option value="Hours" {{ $course->duration_unit === 'Hours' ? 'selected' : '' }}>Hours</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="active" {{ $course->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $course->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Fee Structure</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Standard Course Fee (₹) <span class="text-danger">*</span></label>
                <input type="number" name="course_fee" id="course_fee" class="form-control rounded-3" value="{{ old('course_fee', $course->course_fee) }}" required min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Discount Amount (₹)</label>
                <input type="number" name="discount_fee" id="discount_fee" class="form-control rounded-3" value="{{ old('discount_fee', $course->discount_fee) }}" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Final Payable Fee (₹)</label>
                <input type="text" id="final_fee_display" class="form-control rounded-3 bg-light fw-bold text-primary" readonly value="₹{{ number_format($course->final_fee) }}">
            </div>
        </div>

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Course Descriptions & Media</h5>
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label fw-semibold">Short Summary</label>
                <textarea name="short_description" class="form-control rounded-3" rows="2">{{ old('short_description', $course->short_description) }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Full Detailed Description</label>
                <textarea name="full_description" class="form-control rounded-3" rows="5">{{ old('full_description', $course->full_description) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Learning Outcomes</label>
                <textarea name="learning_outcomes" class="form-control rounded-3" rows="3">{{ old('learning_outcomes', $course->learning_outcomes) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Requirements</label>
                <textarea name="requirements" class="form-control rounded-3" rows="3">{{ old('requirements', $course->requirements) }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Update Image</label>
                <input type="file" name="image" class="form-control rounded-3" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Update Brochure (PDF)</label>
                <input type="file" name="brochure_file" class="form-control rounded-3" accept="application/pdf">
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="featured" id="featuredCheck" value="1" {{ $course->featured ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="featuredCheck">Feature on Homepage</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="certification_available" id="certCheck" value="1" {{ $course->certification_available ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="certCheck">Certificate Available</label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Save Changes</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function updateFinalFee() {
        const fee = parseFloat($('#course_fee').val()) || 0;
        const discount = parseFloat($('#discount_fee').val()) || 0;
        const finalVal = Math.max(0, fee - discount);
        $('#final_fee_display').val('₹' + finalVal.toLocaleString('en-IN'));
    }
    $('#course_fee, #discount_fee').on('input', updateFinalFee);
</script>
@endpush
