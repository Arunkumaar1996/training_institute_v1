@extends('layouts.admin')

@section('title', 'Create New Batch')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Create New Batch</h3>
        <p class="text-muted small mb-0">Set course, assigned instructor, timetable, and student capacity limit</p>
    </div>
    <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Batches
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.batches.store') }}">
        @csrf

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                <select name="course_id" class="form-select rounded-3" required>
                    <option value="">-- Choose Course --</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->course_name }} ({{ $c->level }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Batch Name / Label <span class="text-danger">*</span></label>
                <input type="text" name="batch_name" class="form-control rounded-3" value="{{ old('batch_name') }}" required placeholder="e.g. June Morning Chip Level Batch A">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Primary Trainer / Instructor</label>
                <select name="trainer_id" class="form-select rounded-3">
                    <option value="">-- Assign Trainer --</option>
                    @foreach($trainers as $t)
                        <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->specialization }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                <input type="date" name="start_date" class="form-control rounded-3" value="{{ old('start_date', now()->toDateString()) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">End Date</label>
                <input type="date" name="end_date" class="form-control rounded-3" value="{{ old('end_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Start Time</label>
                <input type="time" name="start_time" class="form-control rounded-3" value="{{ old('start_time', '09:30') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">End Time</label>
                <input type="time" name="end_time" class="form-control rounded-3" value="{{ old('end_time', '13:00') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Days Schedule</label>
                <input type="text" name="days_schedule" class="form-control rounded-3" value="{{ old('days_schedule', 'Mon - Sat') }}" placeholder="e.g. Mon-Sat or Weekend">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Max Student Capacity <span class="text-danger">*</span></label>
                <input type="number" name="max_students" class="form-control rounded-3" value="{{ old('max_students', 20) }}" required min="1">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Room / Lab Number</label>
                <input type="text" name="room_number" class="form-control rounded-3" value="{{ old('room_number', 'Lab 1 - Microscope Station') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Training Mode</label>
                <select name="mode" class="form-select rounded-3">
                    <option value="Offline" selected>Offline (Classroom & Lab)</option>
                    <option value="Online">Online</option>
                    <option value="Hybrid">Hybrid</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Batch Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="Upcoming" selected>Upcoming</option>
                    <option value="Active">Active</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Notes / Special Instructions</label>
                <textarea name="notes" class="form-control rounded-3" rows="2"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.batches.index') }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Create Batch</button>
        </div>
    </form>
</div>
@endsection
