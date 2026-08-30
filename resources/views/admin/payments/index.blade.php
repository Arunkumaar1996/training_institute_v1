@extends('layouts.admin')

@section('title', 'Payment Receipts & Transactions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Payment Receipts</h3>
        <p class="text-muted small mb-0">Total Collections Recorded: <strong class="text-success fs-6">₹{{ number_format($totalCollected) }}</strong></p>
    </div>
    <a href="{{ route('admin.payments.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Record Payment
    </a>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.payments.index') }}">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light" value="{{ request('search') }}" placeholder="Search receipt no, transaction ref, student...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="payment_method" class="form-select bg-light">
                    <option value="">All Payment Methods</option>
                    <option value="Cash" {{ request('payment_method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="UPI" {{ request('payment_method') === 'UPI' ? 'selected' : '' }}>UPI</option>
                    <option value="Bank Transfer" {{ request('payment_method') === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="Card" {{ request('payment_method') === 'Card' ? 'selected' : '' }}>Card</option>
                    <option value="Cheque" {{ request('payment_method') === 'Cheque' ? 'selected' : '' }}>Cheque</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <input type="date" name="start_date" class="form-control bg-light" value="{{ request('start_date') }}" placeholder="From Date">
            </div>
            <div class="col-6 col-md-2">
                <input type="date" name="end_date" class="form-control bg-light" value="{{ request('end_date') }}" placeholder="To Date">
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill"></i></button>
            </div>
        </div>
    </form>
</div>

<!-- Payments Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Receipt No</th>
                    <th>Date</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Amount Paid</th>
                    <th>Payment Method</th>
                    <th>Collected By</th>
                    <th class="text-end pe-4">Receipt Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $pay)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('admin.payments.receipt', $pay->id) }}" class="fw-bold text-primary text-decoration-none">{{ $pay->receipt_number }}</a>
                            <span class="badge bg-light text-muted border text-xs d-block" style="width: fit-content;">{{ $pay->payment_code }}</span>
                        </td>
                        <td class="small">{{ $pay->payment_date->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.students.show', $pay->student_id) }}" class="fw-bold text-dark text-decoration-none d-block small">{{ $pay->student?->full_name }}</a>
                            <span class="text-muted text-xs">{{ $pay->student?->student_code }}</span>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $pay->admission?->course?->course_name }}</span></td>
                        <td class="fw-bold text-success fs-6">₹{{ number_format($pay->amount) }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $pay->payment_method }}</span>
                            @if($pay->transaction_number)<small class="text-muted d-block text-xs">{{ $pay->transaction_number }}</small>@endif
                        </td>
                        <td><small class="text-muted">{{ $pay->collector?->name ?? 'Admin' }}</small></td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.payments.receipt', $pay->id) }}" class="btn btn-outline-dark rounded-pill px-3" title="Print Invoice Receipt">
                                    <i class="bi bi-printer-fill me-1"></i> Print
                                </a>
                                <form method="POST" action="{{ route('admin.payments.destroy', $pay->id) }}" onsubmit="return confirm('Delete this payment transaction? The admission balance will be reverted.');" class="d-inline ms-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger rounded-pill px-2"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No payments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $payments->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
