@extends('layouts.admin')

@section('title', 'Staff: ' . $employee->full_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <div class="d-flex align-items-center gap-2">
            <h3 class="fw-bold text-dark mb-0">{{ $employee->full_name }}</h3>
            <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }} badge-chip">{{ ucfirst($employee->status) }}</span>
        </div>
        <p class="text-muted small mb-0">{{ $employee->employee_code }} • Joined: {{ $employee->joining_date->format('d M Y') }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-outline-primary rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit Profile
        </a>
        <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <img src="{{ $employee->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80' }}" class="rounded-circle object-fit-cover shadow" style="width: 70px; height: 70px;" alt="{{ $employee->full_name }}">
                <div>
                    <h5 class="fw-bold text-dark mb-0">{{ $employee->full_name }}</h5>
                    <span class="badge bg-primary-subtle text-primary">{{ $employee->department?->name ?? 'Staff' }}</span>
                </div>
            </div>

            <table class="table table-sm table-borderless small mb-0">
                <tr><th class="w-35 text-muted">Designation:</th><td class="fw-semibold">{{ $employee->designation?->title ?? 'Staff' }}</td></tr>
                <tr><th class="text-muted">Mobile:</th><td class="fw-semibold">{{ $employee->mobile }}</td></tr>
                <tr><th class="text-muted">Email:</th><td>{{ $employee->email ?: 'N/A' }}</td></tr>
                <tr><th class="text-muted">Gender:</th><td>{{ $employee->gender }}</td></tr>
                <tr><th class="text-muted">Joining Date:</th><td>{{ $employee->joining_date->format('d M Y') }}</td></tr>
                <tr><th class="text-muted">Basic Salary:</th><td class="fw-bold text-success">₹{{ number_format($employee->basic_salary) }} / month</td></tr>
            </table>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-calendar-check me-2"></i> Attendance History</h5>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>In / Out Time</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employee->attendances->sortByDesc('attendance_date')->take(10) as $att)
                            <tr>
                                <td>{{ $att->attendance_date->format('d M Y') }}</td>
                                <td><span class="badge bg-{{ $att->status === 'Present' ? 'success' : 'danger' }}">{{ $att->status }}</span></td>
                                <td>{{ $att->check_in_time ?: '--:--' }} - {{ $att->check_out_time ?: '--:--' }}</td>
                                <td>{{ $att->remarks ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No attendance logs found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
