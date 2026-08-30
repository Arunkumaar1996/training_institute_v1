@extends('layouts.admin')

@section('title', 'Students Directory')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Student Management</h3>
        <p class="text-muted small mb-0">Total {{ $students->total() }} students registered in system</p>
    </div>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
        <i class="bi bi-person-plus-fill me-1"></i> Register Student
    </a>
</div>

<!-- Filters Card -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.students.index') }}">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light" value="{{ request('search') }}" placeholder="Search by name, ID (STU-...), mobile, email...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select bg-light">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="dropped" {{ request('status') === 'dropped' ? 'selected' : '' }}>Dropped</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="batch_id" class="form-select bg-light">
                    <option value="">All Batches</option>
                    @foreach($batches as $b)
                        <option value="{{ $b->id }}" {{ request('batch_id') == $b->id ? 'selected' : '' }}>{{ $b->batch_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill"></i></button>
            </div>
        </div>
    </form>
</div>

<!-- Students Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Student</th>
                    <th>Student ID</th>
                    <th>Mobile & Contact</th>
                    <th>Enrolled Course & Batch</th>
                    <th>Attendance %</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $stu)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $stu->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80' }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 42px; height: 42px;" alt="{{ $stu->full_name }}">
                                <div>
                                    <a href="{{ route('admin.students.show', $stu->id) }}" class="fw-bold text-dark text-decoration-none d-block">{{ $stu->full_name }}</a>
                                    <small class="text-muted">{{ $stu->city ?: 'India' }}</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border fw-bold">{{ $stu->student_code }}</span></td>
                        <td>
                            <div class="small">
                                <div><i class="bi bi-telephone text-muted me-1"></i> {{ $stu->mobile }}</div>
                                @if($stu->email)<div class="text-muted"><i class="bi bi-envelope text-muted me-1"></i> {{ $stu->email }}</div>@endif
                            </div>
                        </td>
                        <td>
                            @if($stu->admissions->isNotEmpty())
                                <span class="badge bg-primary-subtle text-primary">{{ $stu->admissions->first()->course?->course_name }}</span>
                            @else
                                <span class="text-muted small">No active course</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                    <div class="progress-bar bg-{{ $stu->attendance_percentage >= 75 ? 'success' : 'warning' }}" role="progressbar" style="width: {{ $stu->attendance_percentage }}%;"></div>
                                </div>
                                <span class="small fw-semibold">{{ $stu->attendance_percentage }}%</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-{{ $stu->status === 'active' ? 'success' : ($stu->status === 'completed' ? 'primary' : 'secondary') }} badge-chip">
                                {{ ucfirst($stu->status) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.students.show', $stu->id) }}" class="btn btn-outline-primary" title="View 360 Profile"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.students.edit', $stu->id) }}" class="btn btn-outline-secondary" title="Edit Student"><i class="bi bi-pencil"></i></a>
                                <a href="{{ route('admin.admissions.create', ['student_id' => $stu->id]) }}" class="btn btn-outline-success" title="New Admission"><i class="bi bi-plus-circle"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2 text-muted"></i>
                            No student records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $students->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
