@extends('layouts.admin')

@section('title', 'Create Student Admission')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Student Course Admission</h3>
        <p class="text-muted small mb-0">Enroll student in technical course, calculate discount, and record initial fee</p>
    </div>
    <a href="{{ route('admin.admissions.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.admissions.store') }}">
        @csrf

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Student & Course Assignment</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
                <select name="student_id" class="form-select rounded-3" required>
                    <option value="">-- Select Registered Student --</option>
                    @foreach($students as $stu)
                        <option value="{{ $stu->id }}" {{ (old('student_id') == $stu->id || $selectedStudentId == $stu->id) ? 'selected' : '' }}>
                            {{ $stu->full_name }} ({{ $stu->student_code }} • {{ $stu->mobile }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                <select name="course_id" id="course_select" class="form-select rounded-3" required>
                    <option value="">-- Choose Course --</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" data-fee="{{ $c->course_fee }}" data-discount="{{ $c->discount_fee }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->course_name }} ({{ $c->level }}) - ₹{{ number_format($c->final_fee) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Assign Batch</label>
                <select name="batch_id" class="form-select rounded-3">
                    <option value="">-- Select Batch (Optional) --</option>
                    @foreach($batches as $b)
                        <option value="{{ $b->id }}" {{ old('batch_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->batch_name }} (Starts: {{ $b->start_date->format('d M Y') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Assigned Trainer</label>
                <select name="trainer_id" class="form-select rounded-3">
                    <option value="">-- Select Trainer --</option>
                    @foreach($trainers as $t)
                        <option value="{{ $t->id }}">{{ $t->name }} ({{ $t->specialization }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Admission Date <span class="text-danger">*</span></label>
                <input type="date" name="admission_date" class="form-control rounded-3" value="{{ old('admission_date', now()->toDateString()) }}" required>
            </div>
        </div>

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Fee Calculation & Discount</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Standard Course Fee (₹) <span class="text-danger">*</span></label>
                <input type="number" name="course_fee" id="adm_course_fee" class="form-control rounded-3" value="{{ old('course_fee', 15000) }}" required min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Discount (₹)</label>
                <input type="number" name="discount" id="adm_discount" class="form-control rounded-3" value="{{ old('discount', 0) }}" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Final Agreed Fee (₹)</label>
                <input type="text" id="adm_final_fee" class="form-control rounded-3 bg-light fw-bold text-primary" readonly value="₹15,000">
            </div>
        </div>

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Initial Payment / Down Payment</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Initial Payment Amount (₹)</label>
                <input type="number" name="initial_payment" id="adm_initial_pay" class="form-control rounded-3" value="{{ old('initial_payment', 5000) }}" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Payment Method</label>
                <select name="payment_method" class="form-select rounded-3">
                    <option value="Cash">Cash</option>
                    <option value="UPI" selected>UPI (GPay / PhonePe / Paytm)</option>
                    <option value="Bank Transfer">Bank Transfer (NEFT/IMPS)</option>
                    <option value="Card">Credit / Debit Card</option>
                    <option value="Cheque">Cheque</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Transaction / UPI Reference No</label>
                <input type="text" name="transaction_number" class="form-control rounded-3" placeholder="e.g. UPI-1234567890">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Remaining Balance (₹)</label>
                <input type="text" id="adm_remaining_balance" class="form-control rounded-3 bg-light fw-bold text-danger" readonly value="₹10,000">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Balance Due Date</label>
                <input type="date" name="due_date" class="form-control rounded-3" value="{{ old('due_date', now()->addDays(30)->toDateString()) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Admission Source</label>
                <select name="source" class="form-select rounded-3">
                    <option value="Website">Website Enquiry</option>
                    <option value="Walk-in" selected>Walk-in Visit</option>
                    <option value="Referral">Friend / Student Referral</option>
                    <option value="Social Media">Instagram / Facebook / YouTube</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Remarks / Admission Notes</label>
                <textarea name="remarks" class="form-control rounded-3" rows="2"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.admissions.index') }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">
                <i class="bi bi-check2-circle me-1"></i> Confirm & Generate Admission
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function calculateAdmissionTotals() {
        const fee = parseFloat($('#adm_course_fee').val()) || 0;
        const disc = parseFloat($('#adm_discount').val()) || 0;
        const finalFee = Math.max(0, fee - disc);
        const initPay = parseFloat($('#adm_initial_pay').val()) || 0;
        const bal = Math.max(0, finalFee - initPay);

        $('#adm_final_fee').val('₹' + finalFee.toLocaleString('en-IN'));
        $('#adm_remaining_balance').val('₹' + bal.toLocaleString('en-IN'));
    }

    $('#course_select').on('change', function() {
        const selected = $(this).find(':selected');
        const fee = selected.data('fee');
        const disc = selected.data('discount');
        if (fee !== undefined) {
            $('#adm_course_fee').val(fee);
            $('#adm_discount').val(disc || 0);
            calculateAdmissionTotals();
        }
    });

    $('#adm_course_fee, #adm_discount, #adm_initial_pay').on('input', calculateAdmissionTotals);
    calculateAdmissionTotals();
</script>
@endpush
