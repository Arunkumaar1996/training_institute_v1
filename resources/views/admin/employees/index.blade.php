@extends('layouts.admin')

@section('title', 'Staff & Employees Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Staff & Employees Directory</h3>
        <p class="text-muted small mb-0">Total {{ $employees->total() }} institute employees and administrative staff</p>
    </div>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
        <i class="bi bi-person-plus-fill me-1"></i> Add Employee
    </a>
</div>

<!-- Employees Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Employee</th>
                    <th>Code</th>
                    <th>Department & Role</th>
                    <th>Contact</th>
                    <th>Salary</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $emp->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80' }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 42px; height: 42px;" alt="{{ $emp->full_name }}">
                                <div>
                                    <a href="{{ route('admin.employees.show', $emp->id) }}" class="fw-bold text-dark text-decoration-none d-block">{{ $emp->full_name }}</a>
                                    <small class="text-muted">{{ $emp->gender }}</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $emp->employee_code }}</span></td>
                        <td>
                            <div class="small">
                                <span class="badge bg-primary-subtle text-primary">{{ $emp->department?->name ?? 'Staff' }}</span>
                                <small class="text-muted d-block">{{ $emp->designation?->title ?? 'Employee' }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <div><i class="bi bi-telephone text-muted me-1"></i> {{ $emp->mobile }}</div>
                                @if($emp->email)<small class="text-muted">{{ $emp->email }}</small>@endif
                            </div>
                        </td>
                        <td class="fw-semibold">₹{{ number_format($emp->basic_salary) }}</td>
                        <td>
                            <span class="badge bg-{{ $emp->status === 'active' ? 'success' : 'secondary' }} badge-chip">
                                {{ ucfirst($emp->status) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.employees.show', $emp->id) }}" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" class="btn btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No staff records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $employees->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
