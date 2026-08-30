@extends('layouts.admin')

@section('title', 'Fee Collection Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Fee Collection Financial Report</h3>
        <p class="text-muted small mb-0">Period: <strong>{{ date('d M Y', strtotime($startDate)) }}</strong> to <strong>{{ date('d M Y', strtotime($endDate)) }}</strong></p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-3"><i class="bi bi-printer me-1"></i> Print</button>
        <a href="{{ route('admin.reports.fees', array_merge(request()->all(), ['export' => 'csv'])) }}" class="btn btn-success rounded-pill px-3"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV</a>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.reports.fees') }}">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted mb-1">Start Date</label>
                <input type="date" name="start_date" class="form-control bg-light" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted mb-1">End Date</label>
                <input type="date" name="end_date" class="form-control bg-light" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted mb-1">Payment Method</label>
                <select name="payment_method" class="form-select bg-light">
                    <option value="">All Payment Methods</option>
                    <option value="Cash" {{ request('payment_method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="UPI" {{ request('payment_method') === 'UPI' ? 'selected' : '' }}>UPI</option>
                    <option value="Bank Transfer" {{ request('payment_method') === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="Card" {{ request('payment_method') === 'Card' ? 'selected' : '' }}>Card</option>
                </select>
            </div>
            <div class="col-md-3 d-grid align-self-end">
                <button type="submit" class="btn btn-primary rounded-3"><i class="bi bi-funnel-fill me-1"></i> Filter Report</button>
            </div>
        </div>
    </form>
</div>

<!-- Total Summary Card -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-primary text-white">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <span class="text-uppercase small fw-semibold text-white-50">Total Collections in Period</span>
            <h2 class="display-6 fw-bold mb-0">₹{{ number_format($totalCollected) }}</h2>
        </div>
        <div class="bg-white text-primary rounded-circle p-3 fs-2"><i class="bi bi-cash-stack"></i></div>
    </div>
</div>

<!-- Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Receipt</th>
                    <th>Date</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Method</th>
                    <th>Ref No</th>
                    <th class="text-end pe-4">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $pay)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">{{ $pay->receipt_number }}</td>
                        <td>{{ $pay->payment_date->format('d M Y') }}</td>
                        <td>{{ $pay->student?->full_name }}</td>
                        <td>{{ $pay->admission?->course?->course_name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $pay->payment_method }}</span></td>
                        <td><small class="text-muted">{{ $pay->transaction_number ?: '-' }}</small></td>
                        <td class="text-end pe-4 fw-bold text-success">₹{{ number_format($pay->amount) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No payments found in this date range.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
