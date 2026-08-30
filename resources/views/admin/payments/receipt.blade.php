<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $payment->receipt_number }} | {{ \App\Models\Setting::get('institute_name', 'TechMaster Institute') }}</title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f3f4f6; color: #111827; }
        .receipt-container { max-width: 800px; margin: 30px auto; background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .receipt-header { border-bottom: 2px solid #0d6efd; padding-bottom: 20px; margin-bottom: 25px; }
        @media print {
            body { background: #ffffff; }
            .receipt-container { box-shadow: none; padding: 0; margin: 0; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Print / Back Toolbar -->
        <div class="d-flex justify-content-between align-items-center mb-3 no-print max-w-800 mx-auto" style="max-width: 800px;">
            <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to Payments
            </a>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold shadow-sm">
                    <i class="bi bi-printer-fill me-1"></i> Print Receipt
                </button>
            </div>
        </div>

        <!-- Receipt Document Box -->
        <div class="receipt-container">
            <!-- Header -->
            <div class="receipt-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary text-white rounded-3 p-2 text-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-motherboard fs-3"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-primary mb-0">{{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }}</h4>
                        <small class="text-muted d-block">{{ \App\Models\Setting::get('contact_address', 'alwarthirunagar, valasaravakkam, chennai-600 087.') }}</small>
                        <small class="text-muted">Ph: {{ \App\Models\Setting::get('contact_phone', '+91 7418191487') }} • Email: {{ \App\Models\Setting::get('contact_email', 'aruntech1996@gmail.com') }}</small>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary text-uppercase px-3 py-2 fs-6">Official Receipt</span>
                    <div class="fw-bold text-dark mt-2">#{{ $payment->receipt_number }}</div>
                    <small class="text-muted">{{ $payment->payment_date->format('d M Y') }}</small>
                </div>
            </div>

            <!-- Student & Course Details -->
            <div class="row g-3 mb-4 p-3 bg-light rounded-3">
                <div class="col-sm-6">
                    <small class="text-muted text-uppercase fw-semibold d-block">Student Details</small>
                    <h5 class="fw-bold text-dark mb-0">{{ $payment->student?->full_name }}</h5>
                    <small class="text-muted">Student ID: <strong>{{ $payment->student?->student_code }}</strong></small><br>
                    <small class="text-muted">Mobile: {{ $payment->student?->mobile }}</small>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <small class="text-muted text-uppercase fw-semibold d-block">Course & Batch</small>
                    <h6 class="fw-bold text-primary mb-0">{{ $payment->admission?->course?->course_name }}</h6>
                    <small class="text-muted">Admission No: <strong>{{ $payment->admission?->admission_number }}</strong></small><br>
                    <small class="text-muted">Batch: {{ $payment->admission?->batch?->batch_name ?? 'Regular Batch' }}</small>
                </div>
            </div>

            <!-- Ledger Table -->
            <table class="table table-bordered mb-4">
                <thead class="table-light">
                    <tr>
                        <th>Fee Particulars</th>
                        <th class="text-end">Amount (INR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Course Tuition Fee</td>
                        <td class="text-end">₹{{ number_format($payment->admission?->course_fee) }}</td>
                    </tr>
                    @if($payment->admission?->discount > 0)
                        <tr class="text-success">
                            <td>Special Concession / Discount</td>
                            <td class="text-end">- ₹{{ number_format($payment->admission?->discount) }}</td>
                        </tr>
                    @endif
                    <tr class="fw-semibold">
                        <td>Final Agreed Fee</td>
                        <td class="text-end">₹{{ number_format($payment->admission?->final_fee) }}</td>
                    </tr>
                    <tr class="table-primary fw-bold fs-6">
                        <td>Current Received Payment ({{ $payment->payment_method }})</td>
                        <td class="text-end text-success">₹{{ number_format($payment->amount) }}</td>
                    </tr>
                    <tr>
                        <td>Total Amount Paid Till Date</td>
                        <td class="text-end fw-semibold text-primary">₹{{ number_format($payment->admission?->total_paid) }}</td>
                    </tr>
                    <tr class="table-light fw-bold">
                        <td>Remaining Balance Due</td>
                        <td class="text-end text-danger">₹{{ number_format($payment->admission?->balance) }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Payment Meta -->
            <div class="row g-3 mb-4 small text-muted">
                <div class="col-sm-6">
                    <div><strong>Payment Method:</strong> {{ $payment->payment_method }}</div>
                    @if($payment->transaction_number)<div><strong>Transaction Ref:</strong> {{ $payment->transaction_number }}</div>@endif
                    @if($payment->notes)<div><strong>Notes:</strong> {{ $payment->notes }}</div>@endif
                </div>
                <div class="col-sm-6 text-sm-end">
                    <div><strong>Collected By:</strong> {{ $payment->collector?->name ?? 'Accounts Dept' }}</div>
                    <div><strong>Payment Code:</strong> {{ $payment->payment_code }}</div>
                </div>
            </div>

            <!-- Footer Signatures -->
            <div class="row mt-5 pt-4 border-top text-center">
                <div class="col-6">
                    <small class="text-muted d-block mb-4">Student / Guardian Signature</small>
                    <div style="border-bottom: 1px dashed #9ca3af; width: 160px; margin: 0 auto;"></div>
                </div>
                <div class="col-6">
                    <small class="text-muted d-block mb-4">Authorized Seal & Signature</small>
                    <div style="border-bottom: 1px dashed #9ca3af; width: 160px; margin: 0 auto;"></div>
                </div>
            </div>

            <div class="text-center mt-4 pt-3 text-muted text-xs small border-top">
                This is a computer generated payment receipt. Fees once paid are non-refundable according to institute terms.
            </div>
        </div>
    </div>
</body>
</html>
