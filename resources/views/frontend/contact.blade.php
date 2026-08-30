@extends('layouts.frontend')

@section('title', 'Contact Us & Campus Location')

@section('content')
<x-breadcrumb title="Contact Our Admissions & Support Team" :breadcrumbs="['Contact' => route('contact')]" />

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Information & Map -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-primary text-white h-100 d-flex flex-column">
                    <h3 class="fw-bold mb-4">Get in Touch</h3>
                    <p class="text-white-50 mb-4">Have questions about courses, upcoming batch timings, or hostel facilities? Reach out directly to our counselor team.</p>

                    <div class="d-flex flex-column gap-4 mb-5">
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-white text-primary rounded-circle p-2 px-3 fs-5"><i class="bi bi-geo-alt-fill"></i></div>
                            <div>
                                <h6 class="fw-bold text-white mb-1">Campus Address</h6>
                                <p class="text-white-50 small mb-0">{{ \App\Models\Setting::get('contact_address', 'alwarthirunagar, valasaravakkam, chennai-600 087.') }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-white text-primary rounded-circle p-2 px-3 fs-5"><i class="bi bi-telephone-fill"></i></div>
                            <div>
                                <h6 class="fw-bold text-white mb-1">Phone & Helpline</h6>
                                <p class="text-white-50 small mb-0">{{ \App\Models\Setting::get('contact_phone', '+91 7418191487') }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-white text-primary rounded-circle p-2 px-3 fs-5"><i class="bi bi-envelope-fill"></i></div>
                            <div>
                                <h6 class="fw-bold text-white mb-1">Official Email</h6>
                                <p class="text-white-50 small mb-0">{{ \App\Models\Setting::get('contact_email', 'aruntech1996@gmail.com') }}</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-white text-primary rounded-circle p-2 px-3 fs-5"><i class="bi bi-clock-fill"></i></div>
                            <div>
                                <h6 class="fw-bold text-white mb-1">Working Hours</h6>
                                <p class="text-white-50 small mb-0">{{ \App\Models\Setting::get('working_hours', 'Monday - Saturday: 9:00 AM to 7:00 PM') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Message Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <h3 class="fw-bold text-dark mb-2">Send Us a Direct Message</h3>
                    <p class="text-muted small mb-4">We usually respond within 2-4 business hours.</p>

                    <div id="contactFormAlert" class="alert d-none" role="alert"></div>

                    <form id="contactAjaxForm" method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Your Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control rounded-3" required placeholder="Enter full name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mobile Number</label>
                                <input type="tel" name="mobile" class="form-control rounded-3" placeholder="10-digit mobile number">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control rounded-3" required placeholder="name@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Subject</label>
                                <input type="text" name="subject" class="form-control rounded-3" placeholder="Course inquiry, batch timing, certificate...">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Message <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control rounded-3" rows="5" required placeholder="Type your detailed message or questions here..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" id="btnSubmitContact" class="btn btn-primary px-4 py-3 rounded-pill fw-bold shadow-sm">
                                    <span class="spinner-border spinner-border-sm d-none me-1" id="contactSpinner" role="status"></span>
                                    <i class="bi bi-send-fill me-1"></i> Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#contactAjaxForm').on('submit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const $btn = $('#btnSubmitContact');
            const $spinner = $('#contactSpinner');
            const $alert = $('#contactFormAlert');

            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');
            $alert.addClass('d-none').removeClass('alert-success alert-danger');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function(res) {
                    $alert.removeClass('d-none').addClass('alert-success')
                        .html('<i class="bi bi-check-circle-fill me-2"></i> ' + res.message);
                    $form[0].reset();
                },
                error: function(xhr) {
                    let err = 'Unable to send message. Please verify the input fields.';
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
