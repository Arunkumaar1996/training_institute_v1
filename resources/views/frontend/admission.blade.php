@extends('layouts.frontend')

@section('title', 'Online Student Admission & Course Application')
@section('meta_description', 'Apply online for upcoming batches in mobile repairing, laptop motherboard hardware, and chip-level technical engineering.')

@section('content')
<x-breadcrumb title="Student Online Admission Application" :breadcrumbs="['Admission' => route('admission')]" />

<section class="py-5">
    <div class="container max-w-900 mx-auto">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
            <div class="card-header bg-primary text-white p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white text-primary rounded-circle p-2 px-3 fs-3"><i class="bi bi-person-check-fill"></i></div>
                    <div>
                        <h4 class="fw-bold text-white mb-0">Student Enrollment Form</h4>
                        <small class="text-white-50">Fill your application details to reserve your seat in the upcoming technical batch.</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <div id="admissionAlert" class="alert d-none" role="alert"></div>

                <form id="onlineAdmissionForm" method="POST" action="{{ route('enquiry.submit') }}">
                    @csrf
                    <!-- Personal Info -->
                    <h5 class="fw-bold text-primary mb-3 border-bottom pb-2"><i class="bi bi-person-badge-fill me-2"></i> Personal Information</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Candidate Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" required placeholder="Full Name as per ID">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                            <input type="tel" name="mobile" class="form-control rounded-3" required placeholder="Primary 10-digit mobile">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3" placeholder="name@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Current Qualification</label>
                            <input type="text" name="qualification" class="form-control rounded-3" placeholder="10th, 12th, ITI, Diploma, B.E...">
                        </div>
                    </div>

                    <!-- Course & Batch Selection -->
                    <h5 class="fw-bold text-primary mb-3 border-bottom pb-2"><i class="bi bi-journal-code me-2"></i> Course & Batch Selection</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Select Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="admissionCourseSelect" class="form-select rounded-3" required>
                                <option value="">-- Select Technical Course --</option>
                                @foreach($courses as $c)
                                    <option value="{{ $c->id }}" data-fee="{{ $c->final_fee }}" data-duration="{{ $c->duration }} {{ $c->duration_unit }}">{{ $c->course_name }} ({{ $c->level }}) - ₹{{ number_format($c->final_fee) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Preferred Batch</label>
                            <select name="batch_id" class="form-select rounded-3">
                                <option value="">-- Choose Starting Batch --</option>
                                @foreach($batches as $b)
                                    <option value="{{ $b->id }}">{{ $b->batch_name }} (Starts: {{ $b->start_date->format('d M Y') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Any Comments, Questions or Hostel Requirement?</label>
                            <textarea name="message" class="form-control rounded-3" rows="3" placeholder="Please specify if you need hostel accommodation, weekend batch, or special timing..."></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid pt-2">
                        <button type="submit" id="btnSubmitAdmission" class="btn btn-warning btn-lg fw-bold text-dark rounded-pill py-3 shadow">
                            <span class="spinner-border spinner-border-sm d-none me-1" id="admissionSpinner" role="status"></span>
                            <i class="bi bi-check2-circle me-1"></i> Submit Online Admission Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#onlineAdmissionForm').on('submit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const $btn = $('#btnSubmitAdmission');
            const $spinner = $('#admissionSpinner');
            const $alert = $('#admissionAlert');

            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');
            $alert.addClass('d-none').removeClass('alert-success alert-danger');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function(res) {
                    $alert.removeClass('d-none').addClass('alert-success')
                        .html('<i class="bi bi-check-circle-fill me-2 fs-5"></i> <strong>Application Received!</strong> ' + res.message + '<br>Application Reference No: <strong>' + res.data.enquiry_code + '</strong>');
                    $form[0].reset();
                },
                error: function(xhr) {
                    let err = 'Unable to process admission application. Please check the input fields.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        err = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    $alert.removeClass('d-none').addClass('alert-danger')
                        .html('<i class="bi bi-exclamation-triangle-fill me-2"></i> ' + err);
                },
                complete: function() {
                    $btn.prop('disabled', false);
                    $spinner.addClass('d-none');
                }
            });
        });
    });
</script>
@endpush
