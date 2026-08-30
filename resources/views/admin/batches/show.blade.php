@extends('layouts.admin')

@section('title', 'Batch Details: ' . $batch->batch_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <div class="d-flex align-items-center gap-2">
            <h3 class="fw-bold text-dark mb-0">{{ $batch->batch_name }}</h3>
            <span class="badge bg-{{ $batch->status === 'Active' ? 'success' : 'info' }} badge-chip">{{ $batch->status }}</span>
        </div>
        <p class="text-muted small mb-0">Code: <strong>{{ $batch->batch_code }}</strong> • Course: <strong>{{ $batch->course?->course_name }}</strong></p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.attendance.students', ['batch_id' => $batch->id]) }}" class="btn btn-success rounded-pill px-3 shadow-sm">
            <i class="bi bi-check2-square me-1"></i> Mark Attendance
        </a>
        <a href="{{ route('admin.batches.edit', $batch->id) }}" class="btn btn-outline-primary rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit Batch
        </a>
        <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Batch Info Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-primary mb-3">Batch Information</h5>
            <table class="table table-sm table-borderless small mb-0">
                <tr><th class="w-40 text-muted">Primary Trainer:</th><td class="fw-semibold text-dark">{{ $batch->trainer?->name ?? 'Unassigned' }}</td></tr>
                <tr><th class="text-muted">Start Date:</th><td>{{ $batch->start_date->format('d M Y') }}</td></tr>
                <tr><th class="text-muted">End Date:</th><td>{{ $batch->end_date ? $batch->end_date->format('d M Y') : 'Ongoing' }}</td></tr>
                <tr><th class="text-muted">Timings:</th><td>{{ $batch->start_time ?: 'Morning' }} - {{ $batch->end_time ?: 'Batch' }}</td></tr>
                <tr><th class="text-muted">Days:</th><td>{{ $batch->days_schedule }}</td></tr>
                <tr><th class="text-muted">Room / Lab:</th><td>{{ $batch->room_number ?: 'Lab 1' }}</td></tr>
                <tr><th class="text-muted">Training Mode:</th><td><span class="badge bg-light text-dark border">{{ $batch->mode }}</span></td></tr>
            </table>

            <!-- Capacity Progress -->
            <div class="mt-4 pt-3 border-top">
                <div class="d-flex justify-content-between small fw-semibold mb-1">
                    <span>Enrolled Students</span>
                    <span class="{{ $batch->is_full ? 'text-danger' : 'text-primary' }}">{{ $batch->students->count() }} / {{ $batch->max_students }} ({{ $batch->is_full ? 'FULL' : 'Seats Available' }})</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-{{ $batch->is_full ? 'danger' : 'primary' }}" role="progressbar" style="width: {{ ($batch->students->count() / max(1, $batch->max_students)) * 100 }}%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrolled Students & Assignment -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-primary mb-0"><i class="bi bi-people-fill me-2"></i> Enrolled Students ({{ $batch->students->count() }})</h5>
                @if(!$batch->is_full)
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#assignStudentModal">
                        <i class="bi bi-person-plus me-1"></i> Assign Students
                    </button>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Student ID</th>
                            <th>Mobile</th>
                            <th>Joined Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($batch->students as $stu)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $stu->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" class="rounded-circle object-fit-cover" style="width: 32px; height: 32px;" alt="{{ $stu->full_name }}">
                                        <a href="{{ route('admin.students.show', $stu->id) }}" class="fw-bold text-dark text-decoration-none">{{ $stu->full_name }}</a>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $stu->student_code }}</span></td>
                                <td>{{ $stu->mobile }}</td>
                                <td>{{ $stu->pivot->assigned_date ? date('d M Y', strtotime($stu->pivot->assigned_date)) : '-' }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.batches.remove-student', [$batch->id, $stu->id]) }}" onsubmit="return confirm('Remove student from this batch?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove from batch"><i class="bi bi-x-circle"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No students assigned to this batch yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Assign Students Modal -->
<div class="modal fade" id="assignStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Assign Students to {{ $batch->batch_name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.batches.assign-students', $batch->id) }}">
                @csrf
                <div class="modal-body p-4">
                    <p class="small text-muted mb-3">Select registered active students to enroll in this batch. Max remaining capacity: <strong>{{ $batch->max_students - $batch->students->count() }} seats</strong>.</p>
                    
                    <div class="row g-2" style="max-height: 350px; overflow-y: auto;">
                        @forelse($availableStudents as $availStu)
                            <div class="col-md-6">
                                <div class="form-check p-2 bg-light rounded border d-flex align-items-center gap-2">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="student_ids[]" value="{{ $availStu->id }}" id="stuCheck{{ $availStu->id }}">
                                    <label class="form-check-label small d-flex flex-column" for="stuCheck{{ $availStu->id }}">
                                        <strong class="text-dark">{{ $availStu->full_name }}</strong>
                                        <span class="text-muted text-xs">{{ $availStu->student_code }} • {{ $availStu->mobile }}</span>
                                    </label>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small ps-2">No unassigned active students available.</p>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Assign Selected Students</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
