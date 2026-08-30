@extends('layouts.admin')

@section('title', 'Batch Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Batch Management</h3>
        <p class="text-muted small mb-0">Manage batch schedules, timetables, rooms, and trainer allocations</p>
    </div>
    <a href="{{ route('admin.batches.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Create Batch
    </a>
</div>

<!-- Batches Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Batch</th>
                    <th>Course</th>
                    <th>Trainer</th>
                    <th>Schedule & Timing</th>
                    <th>Enrolled / Capacity</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($batches as $b)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('admin.batches.show', $b->id) }}" class="fw-bold text-dark text-decoration-none d-block">{{ $b->batch_name }}</a>
                            <span class="badge bg-light text-muted border text-xs">{{ $b->batch_code }}</span>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $b->course?->course_name }}</span></td>
                        <td>
                            <span class="small fw-semibold text-dark">{{ $b->trainer?->name ?? 'Unassigned' }}</span>
                        </td>
                        <td>
                            <div class="small">
                                <div><i class="bi bi-calendar3 me-1 text-muted"></i> {{ $b->start_date->format('d M Y') }}</div>
                                <span class="text-muted">{{ $b->days_schedule }} ({{ $b->mode }})</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                    <div class="progress-bar bg-{{ $b->is_full ? 'danger' : 'primary' }}" role="progressbar" style="width: {{ ($b->students_count / max(1, $b->max_students)) * 100 }}%;"></div>
                                </div>
                                <span class="small fw-semibold">{{ $b->students_count }}/{{ $b->max_students }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-{{ $b->status === 'Active' ? 'success' : ($b->status === 'Upcoming' ? 'info' : 'secondary') }} badge-chip">
                                {{ $b->status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.batches.show', $b->id) }}" class="btn btn-outline-primary" title="View Batch & Students"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.attendance.students', ['batch_id' => $b->id]) }}" class="btn btn-outline-success" title="Mark Attendance"><i class="bi bi-check2-square"></i></a>
                                <a href="{{ route('admin.batches.edit', $b->id) }}" class="btn btn-outline-secondary" title="Edit Batch"><i class="bi bi-pencil"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No batches created yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $batches->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
