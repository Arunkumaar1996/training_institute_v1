@extends('layouts.admin')

@section('title', 'Fees & Financial Ledger')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Fees Management & Collection</h3>
        <p class="text-muted small mb-0">Monitor total course fees, collections, outstanding balances, and pending dues</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.payments.create') }}" class="btn btn-success rounded-pill px-3 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Collect Payment
        </a>
        <a href="{{ route('admin.fees.overdue') }}" class="btn btn-outline-danger rounded-pill px-3">
            <i class="bi bi-exclamation-octagon-fill me-1"></i> Overdue Fees
        </a>
    </div>
</div>

<!-- Financial Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <span class="text-muted small text-uppercase fw-semibold">Total Revenue Expected</span>
            <h3 class="fw-bold text-primary my-1">₹{{ number_format($stats['total_fee']) }}</h3>
            <small class="text-muted">Net after course discounts</small>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <span class="text-muted small text-uppercase fw-semibold">Total Collected</span>
            <h3 class="fw-bold text-success my-1">₹{{ number_format($stats['total_collected']) }}</h3>
            <small class="text-success"><i class="bi bi-check-all me-1"></i> Received in bank/cash</small>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <span class="text-muted small text-uppercase fw-semibold">Outstanding Balance</span>
            <h3 class="fw-bold text-danger my-1">₹{{ number_format($stats['total_pending']) }}</h3>
            <small class="text-danger">To be collected</small>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <span class="text-muted small text-uppercase fw-semibold">Overdue Balance</span>
            <h3 class="fw-bold text-warning my-1">₹{{ number_format($stats['total_overdue']) }}</h3>
            <small class="text-danger"><i class="bi bi-clock-history me-1"></i> Past due date</small>
        </div>
    </div>
</div>

<!-- Student Fee Ledger Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Student</th>
                    <th>Admission No</th>
                    <th>Course</th>
                    <th>Final Fee</th>
                    <th>Paid Amount</th>
                    <th>Balance Due</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admissions as $adm)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('admin.students.show', $adm->student_id) }}" class="fw-bold text-dark text-decoration-none d-block">{{ $adm->student?->full_name }}</a>
                            <small class="text-muted">{{ $adm->student?->student_code }} • {{ $adm->student?->mobile }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $adm->admission_number }}</span></td>
                        <td>{{ $adm->course?->course_name }}</td>
                        <td class="fw-semibold">₹{{ number_format($adm->final_fee) }}</td>
                        <td class="fw-bold text-success">₹{{ number_format($adm->total_paid) }}</td>
                        <td class="fw-bold text-{{ $adm->balance > 0 ? 'danger' : 'muted' }}">₹{{ number_format($adm->balance) }}</td>
                        <td>
                            <span class="badge bg-{{ $adm->payment_status === 'Paid' ? 'success' : ($adm->payment_status === 'Partially Paid' ? 'warning' : 'danger') }} badge-chip">
                                {{ $adm->payment_status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            @if($adm->balance > 0)
                                <a href="{{ route('admin.payments.create', ['admission_id' => $adm->id]) }}" class="btn btn-sm btn-success rounded-pill px-3">
                                    <i class="bi bi-credit-card me-1"></i> Collect
                                </a>
                            @else
                                <span class="badge bg-light text-success border"><i class="bi bi-check-circle-fill me-1"></i> Fully Paid</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No student fee records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $admissions->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
