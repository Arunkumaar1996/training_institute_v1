@extends('layouts.admin')

@section('title', 'Issue Course Certificate')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Issue Student Certificate</h3>
        <p class="text-muted small mb-0">Generate authorized course completion credential with automated verification hash</p>
    </div>
    <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.certificates.store') }}">
        @csrf

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Select Student <span class="text-danger">*</span></label>
                <select name="student_id" class="form-select rounded-3" required>
                    <option value="">-- Choose Student --</option>
                    @foreach($students as $stu)
                        <option value="{{ $stu->id }}" {{ old('student_id') == $stu->id ? 'selected' : '' }}>
                            {{ $stu->full_name }} ({{ $stu->student_code }} • Attendance: {{ $stu->attendance_percentage }}%)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                <select name="course_id" class="form-select rounded-3" required>
                    <option value="">-- Choose Course Completed --</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->course_name }} ({{ $c->level }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Certificate Template</label>
                <select name="template_id" class="form-select rounded-3">
                    <option value="">Default Classic Gold Border</option>
                    @foreach($templates as $tmpl)
                        <option value="{{ $tmpl->id }}">{{ $tmpl->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Issue Date <span class="text-danger">*</span></label>
                <input type="date" name="issue_date" class="form-control rounded-3" value="{{ old('issue_date', now()->toDateString()) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Grade / Performance Evaluation</label>
                <select name="grade" class="form-select rounded-3">
                    <option value="A+ (Distinction)" selected>A+ (Distinction - Master Technician)</option>
                    <option value="A (Excellent)">A (Excellent)</option>
                    <option value="B+ (Very Good)">B+ (Very Good)</option>
                    <option value="B (Good)">B (Good)</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">
                <i class="bi bi-award-fill me-1"></i> Generate & Issue Certificate
            </button>
        </div>
    </form>
</div>
@endsection
