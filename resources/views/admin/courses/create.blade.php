@extends('layouts.admin')

@section('title', 'Add New Course')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Create New Course</h3>
        <p class="text-muted small mb-0">Define course code, pricing, syllabus, and brochure details</p>
    </div>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Courses
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
        @csrf

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Basic Course Information</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Course Name <span class="text-danger">*</span></label>
                <input type="text" name="course_name" class="form-control rounded-3" value="{{ old('course_name') }}" required placeholder="e.g. Advanced Mobile Chip Level Engineering">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Course Code <span class="text-danger">*</span></label>
                <input type="text" name="course_code" class="form-control rounded-3" value="{{ old('course_code') }}" required placeholder="e.g. MCL-301">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Category</label>
                <select name="category_id" class="form-select rounded-3">
                    <option value="">-- Choose Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Skill Level</label>
                <select name="level" class="form-select rounded-3">
                    <option value="Basic">Basic</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                    <option value="Basic to Advanced" selected>Basic to Advanced</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Duration (Number) <span class="text-danger">*</span></label>
                <input type="number" name="duration" class="form-control rounded-3" value="{{ old('duration', 30) }}" required min="1">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Duration Unit</label>
                <select name="duration_unit" class="form-select rounded-3">
                    <option value="Days" selected>Days</option>
                    <option value="Weeks">Weeks</option>
                    <option value="Months">Months</option>
                    <option value="Hours">Hours</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Sort Order</label>
                <input type="number" name="sort_order" class="form-control rounded-3" value="{{ old('sort_order', 0) }}">
            </div>
        </div>

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Fee Structure</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Standard Course Fee (₹) <span class="text-danger">*</span></label>
                <input type="number" name="course_fee" id="course_fee" class="form-control rounded-3" value="{{ old('course_fee', 15000) }}" required min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Discount Amount (₹)</label>
                <input type="number" name="discount_fee" id="discount_fee" class="form-control rounded-3" value="{{ old('discount_fee', 2000) }}" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Final Payable Fee (₹)</label>
                <input type="text" id="final_fee_display" class="form-control rounded-3 bg-light fw-bold text-primary" readonly value="₹13,000">
            </div>
        </div>

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Course Descriptions & Media</h5>
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label fw-semibold">Short Summary / Highlights</label>
                <textarea name="short_description" class="form-control rounded-3" rows="2" placeholder="Brief outline shown in course preview cards..."></textarea>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Full Detailed Description</label>
                <textarea name="full_description" class="form-control rounded-3" rows="5" placeholder="Complete course details, tools covered, practical lab structure..."></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Learning Outcomes (Bullet points)</label>
                <textarea name="learning_outcomes" class="form-control rounded-3" rows="3" placeholder="What the candidate will master..."></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Prerequisites</label>
                <textarea name="requirements" class="form-control rounded-3" rows="3" placeholder="Basic literacy, enthusiasm to learn electronics..."></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Course Featured Image</label>
                <input type="file" name="image" class="form-control rounded-3" accept="image/*">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Downloadable Brochure (PDF)</label>
                <input type="file" name="brochure_file" class="form-control rounded-3" accept="application/pdf">
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="featured" id="featuredCheck" value="1">
                    <label class="form-check-label fw-semibold" for="featuredCheck">Feature on Homepage</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" name="certification_available" id="certCheck" value="1" checked>
                    <label class="form-check-label fw-semibold" for="certCheck">ISO/Certificate Available</label>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Save & Continue</button>
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
    updateFinalFee();
</script>
@endpush
