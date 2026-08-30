@extends('layouts.admin')

@section('title', 'Overdue Fee Collections')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-danger mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i> Overdue Fee Accounts</h3>
        <p class="text-muted small mb-0">Admissions with pending balance past the designated payment due date</p>
    </div>
    <a href="{{ route('admin.fees.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to All Fees
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Student</th>
                    <th>Admission No</th>
                    <th>Course</th>
                    <th>Due Date</th>
                    <th>Days Overdue</th>
                    <th>Remaining Balance</th>
                    <th class="text-end pe-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($overdueAdmissions as $adm)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('admin.students.show', $adm->student_id) }}" class="fw-bold text-dark text-decoration-none d-block">{{ $adm->student?->full_name }}</a>
                            <small class="text-muted">{{ $adm->student?->mobile }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $adm->admission_number }}</span></td>
                        <td>{{ $adm->course?->course_name }}</td>
                        <td class="text-danger fw-semibold">{{ $adm->due_date ? $adm->due_date->format('d M Y') : 'Expired' }}</td>
                        <td>
                            <span class="badge bg-danger-subtle text-danger">
                                {{ $adm->due_date ? now()->diffInDays($adm->due_date) : 'N/A' }} Days
                            </span>
                        </td>
                        <td class="fw-bold text-danger fs-6">₹{{ number_format($adm->balance) }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.payments.create', ['admission_id' => $adm->id]) }}" class="btn btn-sm btn-danger rounded-pill px-3 shadow-sm">
                                <i class="bi bi-credit-card me-1"></i> Settle Due
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">No overdue accounts. All student fees are currently settled!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $overdueAdmissions->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
