@extends('layouts.admin')

@section('title', 'Edit Batch: ' . $batch->batch_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Edit Batch: {{ $batch->batch_name }}</h3>
        <p class="text-muted small mb-0">Code: {{ $batch->batch_code }}</p>
    </div>
    <a href="{{ route('admin.batches.show', $batch->id) }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> View Batch
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.batches.update', $batch->id) }}">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                <select name="course_id" class="form-select rounded-3" required>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ $batch->course_id == $c->id ? 'selected' : '' }}>{{ $c->course_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Batch Name <span class="text-danger">*</span></label>
                <input type="text" name="batch_name" class="form-control rounded-3" value="{{ old('batch_name', $batch->batch_name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Primary Trainer</label>
                <select name="trainer_id" class="form-select rounded-3">
                    <option value="">-- Unassigned --</option>
                    @foreach($trainers as $t)
                        <option value="{{ $t->id }}" {{ $batch->trainer_id == $t->id ? 'selected' : '' }}>{{ $t->name }} ({{ $t->specialization }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                <input type="date" name="start_date" class="form-control rounded-3" value="{{ old('start_date', $batch->start_date?->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">End Date</label>
                <input type="date" name="end_date" class="form-control rounded-3" value="{{ old('end_date', $batch->end_date?->format('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Start Time</label>
                <input type="time" name="start_time" class="form-control rounded-3" value="{{ old('start_time', $batch->start_time) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">End Time</label>
                <input type="time" name="end_time" class="form-control rounded-3" value="{{ old('end_time', $batch->end_time) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Days Schedule</label>
                <input type="text" name="days_schedule" class="form-control rounded-3" value="{{ old('days_schedule', $batch->days_schedule) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Max Student Capacity <span class="text-danger">*</span></label>
                <input type="number" name="max_students" class="form-control rounded-3" value="{{ old('max_students', $batch->max_students) }}" required min="1">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Room / Lab</label>
                <input type="text" name="room_number" class="form-control rounded-3" value="{{ old('room_number', $batch->room_number) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Mode</label>
                <select name="mode" class="form-select rounded-3">
                    <option value="Offline" {{ $batch->mode === 'Offline' ? 'selected' : '' }}>Offline</option>
                    <option value="Online" {{ $batch->mode === 'Online' ? 'selected' : '' }}>Online</option>
                    <option value="Hybrid" {{ $batch->mode === 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="Upcoming" {{ $batch->status === 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="Active" {{ $batch->status === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Completed" {{ $batch->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ $batch->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.batches.show', $batch->id) }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Update Batch</button>
        </div>
    </form>
</div>
@endsection
