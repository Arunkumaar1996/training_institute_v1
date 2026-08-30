@extends('layouts.admin')

@section('title', 'Collect Fee Payment')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Record Fee Payment</h3>
        <p class="text-muted small mb-0">Issue payment receipt, auto update student balance, and generate invoice</p>
    </div>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.payments.store') }}">
        @csrf

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Select Admission Account <span class="text-danger">*</span></label>
                <select name="admission_id" id="payment_adm_select" class="form-select rounded-3" required>
                    <option value="">-- Choose Student & Course --</option>
                    @foreach($admissions as $adm)
                        <option value="{{ $adm->id }}" data-balance="{{ $adm->balance }}" {{ (old('admission_id') == $adm->id || $selectedAdmissionId == $adm->id) ? 'selected' : '' }}>
                            {{ $adm->student?->full_name }} ({{ $adm->admission_number }}) - {{ $adm->course?->course_name }} • Balance: ₹{{ number_format($adm->balance) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Current Pending Balance</label>
                <input type="text" id="pending_balance_display" class="form-control rounded-3 bg-light fw-bold text-danger" readonly value="₹0">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Payment Date <span class="text-danger">*</span></label>
                <input type="date" name="payment_date" class="form-control rounded-3" value="{{ old('payment_date', now()->toDateString()) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Amount to Pay (₹) <span class="text-danger">*</span></label>
                <input type="number" name="amount" id="pay_amount" class="form-control rounded-3 fw-bold text-success" value="{{ old('amount') }}" required min="1">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                <select name="payment_method" class="form-select rounded-3" required>
                    <option value="Cash">Cash</option>
                    <option value="UPI" selected>UPI (GPay / PhonePe / Paytm / BHIM)</option>
                    <option value="Bank Transfer">Bank Transfer (NEFT / RTGS / IMPS)</option>
                    <option value="Card">Credit / Debit Card (POS)</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Online">Online Gateway</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Transaction / Ref Number</label>
                <input type="text" name="transaction_number" class="form-control rounded-3" placeholder="e.g. UPI Ref / Bank UTR / Cheque No">
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Payment Remarks / Notes</label>
                <textarea name="notes" class="form-control rounded-3" rows="2" placeholder="e.g. 2nd installment paid via GPay"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-success px-5 rounded-pill fw-bold shadow-sm">
                <i class="bi bi-printer-fill me-1"></i> Record & Generate Receipt
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function updateBalance() {
        const selected = $('#payment_adm_select').find(':selected');
        const bal = selected.data('balance');
        if (bal !== undefined) {
            $('#pending_balance_display').val('₹' + parseFloat(bal).toLocaleString('en-IN'));
            if (!$('#pay_amount').val()) {
                $('#pay_amount').val(bal);
            }
        }
    }
    $('#payment_adm_select').on('change', updateBalance);
    updateBalance();
</script>
@endpush
