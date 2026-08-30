@extends('layouts.admin')

@section('title', 'Employee & Staff Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Staff & Faculty Attendance</h3>
        <p class="text-muted small mb-0">Track daily check-in, check-out, leaves, and presence for institute employees</p>
    </div>
    <a href="{{ route('admin.attendance.students') }}" class="btn btn-outline-primary rounded-pill px-3">
        <i class="bi bi-people me-1"></i> Student Attendance
    </a>
</div>

<!-- Date Picker Card -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.attendance.employees') }}" class="row g-3 align-items-center">
        <div class="col-md-4">
            <label class="form-label small fw-semibold text-muted mb-1">Select Attendance Date</label>
            <input type="date" name="date" class="form-control bg-light" value="{{ $date }}" onchange="this.form.submit()">
        </div>
        <div class="col-md-2 d-grid align-self-end">
            <button type="submit" class="btn btn-primary rounded-3"><i class="bi bi-arrow-repeat me-1"></i> Filter Date</button>
        </div>
    </form>
</div>

<!-- Employee Attendance List -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Employee</th>
                    <th>Department & Role</th>
                    <th>Current Status</th>
                    <th>Check-in / Check-out</th>
                    <th>Quick Mark</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    @php $att = $existing->get($emp->id); @endphp
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $emp->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" class="rounded-circle object-fit-cover" style="width: 38px; height: 38px;" alt="{{ $emp->full_name }}">
                                <div>
                                    <strong class="text-dark d-block small">{{ $emp->full_name }}</strong>
                                    <span class="text-muted text-xs">{{ $emp->employee_code }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <span class="badge bg-primary-subtle text-primary">{{ $emp->department?->name ?? 'Staff' }}</span>
                                <small class="text-muted d-block">{{ $emp->designation?->title ?? 'Employee' }}</small>
                            </div>
                        </td>
                        <td>
                            @if($att)
                                <span class="badge bg-{{ $att->status === 'Present' ? 'success' : ($att->status === 'Late' ? 'warning' : 'danger') }} badge-chip">
                                    {{ $att->status }}
                                </span>
                            @else
                                <span class="badge bg-light text-muted border">Not Marked</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">In: {{ $att?->check_in_time ?: '--:--' }} | Out: {{ $att?->check_out_time ?: '--:--' }}</small>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.attendance.employees.save') }}" class="d-flex gap-1">
                                @csrf
                                <input type="hidden" name="employee_id" value="{{ $emp->id }}">
                                <input type="hidden" name="attendance_date" value="{{ $date }}">
                                <select name="status" class="form-select form-select-sm rounded-3" style="width: 120px;">
                                    <option value="Present" {{ $att?->status === 'Present' ? 'selected' : '' }}>Present</option>
                                    <option value="Absent" {{ $att?->status === 'Absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="Late" {{ $att?->status === 'Late' ? 'selected' : '' }}>Late</option>
                                    <option value="Half Day" {{ $att?->status === 'Half Day' ? 'selected' : '' }}>Half Day</option>
                                    <option value="Leave" {{ $att?->status === 'Leave' ? 'selected' : '' }}>Leave</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary rounded-3"><i class="bi bi-check2"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">No active staff members found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
