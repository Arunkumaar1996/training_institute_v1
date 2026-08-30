@extends('layouts.admin')

@section('title', 'Admission Invoice: ' . $admission->admission_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <div class="d-flex align-items-center gap-2">
            <h3 class="fw-bold text-dark mb-0">Admission #{{ $admission->admission_number }}</h3>
            <span class="badge bg-{{ $admission->payment_status === 'Paid' ? 'success' : ($admission->payment_status === 'Partially Paid' ? 'warning' : 'danger') }} badge-chip">
                {{ $admission->payment_status }}
            </span>
        </div>
        <p class="text-muted small mb-0">Date: {{ $admission->admission_date->format('d M Y') }}</p>
    </div>
    <div class="d-flex gap-2">
        @if($admission->balance > 0)
            <a href="{{ route('admin.payments.create', ['admission_id' => $admission->id]) }}" class="btn btn-success rounded-pill px-3 shadow-sm">
                <i class="bi bi-credit-card me-1"></i> Collect Fee (Balance: ₹{{ number_format($admission->balance) }})
            </a>
        @endif
        <a href="{{ route('admin.admissions.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Student & Course Details -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-primary mb-3">Student & Course Details</h5>
            <div class="d-flex align-items-center gap-3 mb-3 p-3 bg-light rounded-3">
                <img src="{{ $admission->student?->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80' }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 50px; height: 50px;" alt="{{ $admission->student?->full_name }}">
                <div>
                    <h6 class="fw-bold text-dark mb-0">
                        <a href="{{ route('admin.students.show', $admission->student_id) }}" class="text-dark text-decoration-none">{{ $admission->student?->full_name }}</a>
                    </h6>
                    <small class="text-muted">{{ $admission->student?->student_code }} • {{ $admission->student?->mobile }}</small>
                </div>
            </div>

            <table class="table table-sm table-borderless small mb-0">
                <tr><th class="w-40 text-muted">Course:</th><td class="fw-bold text-dark">{{ $admission->course?->course_name }}</td></tr>
                <tr><th class="text-muted">Assigned Batch:</th><td>{{ $admission->batch?->batch_name ?? 'No batch assigned' }}</td></tr>
                <tr><th class="text-muted">Trainer:</th><td>{{ $admission->trainer?->name ?? 'Institute Faculty' }}</td></tr>
                <tr><th class="text-muted">Admission Status:</th><td><span class="badge bg-success">{{ $admission->admission_status }}</span></td></tr>
                <tr><th class="text-muted">Source:</th><td>{{ $admission->source }}</td></tr>
            </table>
        </div>

        <!-- Financial Summary Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary text-white">
            <h5 class="fw-bold text-white mb-3">Fee Settlement Summary</h5>
            <div class="d-flex justify-content-between mb-2">
                <span>Original Course Fee:</span>
                <strong>₹{{ number_format($admission->course_fee) }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2 text-warning">
                <span>Discount / Concession:</span>
                <strong>- ₹{{ number_format($admission->discount) }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-3 fs-5 fw-bold border-top pt-2">
                <span>Final Payable Fee:</span>
                <span>₹{{ number_format($admission->final_fee) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2 text-success-emphasis bg-white p-2 rounded-3 text-dark">
                <span>Total Amount Paid:</span>
                <strong class="text-success fs-5">₹{{ number_format($admission->total_paid) }}</strong>
            </div>
            <div class="d-flex justify-content-between pt-2">
                <span>Remaining Balance:</span>
                <strong class="fs-5 {{ $admission->balance > 0 ? 'text-warning' : 'text-white' }}">₹{{ number_format($admission->balance) }}</strong>
            </div>
        </div>
    </div>

    <!-- Payments & Installment History -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-receipt-cutoff me-2"></i> Payment Transactions</h5>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle small mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Receipt No</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Collected By</th>
                            <th class="text-end">Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admission->payments as $pay)
                            <tr>
                                <td class="fw-bold text-primary">{{ $pay->receipt_number }}</td>
                                <td>{{ $pay->payment_date->format('d M Y') }}</td>
                                <td class="fw-bold text-success">₹{{ number_format($pay->amount) }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $pay->payment_method }}</span></td>
                                <td>{{ $pay->collector?->name ?? 'Admin' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.payments.receipt', $pay->id) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-2">
                                        <i class="bi bi-printer-fill me-1"></i> Receipt
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No payments recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($admission->installments->isNotEmpty())
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-calendar-range me-2"></i> Installment Schedule</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle small mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Due Date</th>
                                <th>Scheduled Amount</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admission->installments as $inst)
                                <tr>
                                    <td>{{ $inst->installment_number }}</td>
                                    <td>{{ $inst->due_date->format('d M Y') }}</td>
                                    <td class="fw-semibold">₹{{ number_format($inst->amount) }}</td>
                                    <td class="text-success">₹{{ number_format($inst->paid_amount) }}</td>
                                    <td class="text-danger">₹{{ number_format($inst->balance) }}</td>
                                    <td><span class="badge bg-{{ $inst->status === 'Paid' ? 'success' : ($inst->status === 'Partially Paid' ? 'warning' : 'danger') }}">{{ $inst->status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
