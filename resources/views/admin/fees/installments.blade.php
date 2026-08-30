@extends('layouts.admin')

@section('title', 'Fee Installment Schedules')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Fee Installment Schedules</h3>
        <p class="text-muted small mb-0">Track upcoming and pending installment payment milestones</p>
    </div>
    <a href="{{ route('admin.fees.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Fees
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Student</th>
                    <th>Course</th>
                    <th>Installment</th>
                    <th>Due Date</th>
                    <th>Scheduled Amount</th>
                    <th>Paid</th>
                    <th>Remaining</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($installments as $inst)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('admin.students.show', $inst->student_id) }}" class="fw-bold text-dark text-decoration-none d-block">{{ $inst->student?->full_name }}</a>
                            <small class="text-muted">{{ $inst->student?->student_code }}</small>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $inst->admission?->course?->course_name }}</span></td>
                        <td class="fw-semibold">Installment #{{ $inst->installment_number }}</td>
                        <td>{{ $inst->due_date->format('d M Y') }}</td>
                        <td>₹{{ number_format($inst->amount) }}</td>
                        <td class="text-success fw-semibold">₹{{ number_format($inst->paid_amount) }}</td>
                        <td class="text-danger fw-bold">₹{{ number_format($inst->balance) }}</td>
                        <td>
                            <span class="badge bg-{{ $inst->status === 'Paid' ? 'success' : ($inst->status === 'Partially Paid' ? 'warning' : 'danger') }} badge-chip">
                                {{ $inst->status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            @if($inst->balance > 0)
                                <a href="{{ route('admin.payments.create', ['admission_id' => $inst->admission_id]) }}" class="btn btn-sm btn-success rounded-pill px-3">Collect</a>
                            @else
                                <span class="badge bg-light text-success border">Paid</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">No installment schedules found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $installments->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
