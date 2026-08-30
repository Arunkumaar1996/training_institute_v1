@extends('layouts.admin')

@section('title', 'Attendance Percentage Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Student Attendance Percentage</h3>
        <p class="text-muted small mb-0">Compute total practical working days, presents, absentees, and eligibility %</p>
    </div>
    <a href="{{ route('admin.attendance.students') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Daily Marking
    </a>
</div>

<!-- Select Batch Filter -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.attendance.reports') }}" class="row g-3 align-items-center">
        <div class="col-md-6">
            <select name="batch_id" class="form-select bg-light" onchange="this.form.submit()">
                <option value="">-- Choose Batch to View Attendance Analytics --</option>
                @foreach($batches as $b)
                    <option value="{{ $b->id }}" {{ $batchId == $b->id ? 'selected' : '' }}>
                        {{ $b->batch_name }} ({{ $b->course?->course_name }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary rounded-3 w-100"><i class="bi bi-bar-chart-fill me-1"></i> Generate</button>
        </div>
    </form>
</div>

@if($batchId)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Student</th>
                        <th>Student Code</th>
                        <th>Total Batch Days</th>
                        <th>Attended Days</th>
                        <th>Attendance %</th>
                        <th>Examination Eligibility</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $row)
                        <tr>
                            <td class="ps-4">
                                <a href="{{ route('admin.students.show', $row['student']->id) }}" class="fw-bold text-dark text-decoration-none d-block small">
                                    {{ $row['student']->full_name }}
                                </a>
                                <small class="text-muted">{{ $row['student']->mobile }}</small>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $row['student']->student_code }}</span></td>
                            <td class="fw-semibold">{{ $row['total_days'] }} Days</td>
                            <td class="fw-bold text-success">{{ $row['present_days'] }} Days</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 8px; width: 80px;">
                                        <div class="progress-bar bg-{{ $row['percentage'] >= 75 ? 'success' : 'danger' }}" role="progressbar" style="width: {{ $row['percentage'] }}%;"></div>
                                    </div>
                                    <span class="fw-bold text-{{ $row['percentage'] >= 75 ? 'success' : 'danger' }} small">{{ $row['percentage'] }}%</span>
                                </div>
                            </td>
                            <td>
                                @if($row['percentage'] >= 75)
                                    <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle-fill me-1"></i> Eligible for Exam & Certificate</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i> Low Attendance (<75%)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No attendance logs available for this batch.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
