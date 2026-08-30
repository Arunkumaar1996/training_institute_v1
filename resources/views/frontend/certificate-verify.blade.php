@extends('layouts.frontend')

@section('title', 'Verify Student Certificate Online')
@section('meta_description', 'Verify student technical course completion certificates online using Certificate Number or QR verification code.')

@section('content')
<x-breadcrumb title="Student Certificate Verification Portal" :breadcrumbs="['Verify Certificate' => route('certificate.verify')]" />

<section class="py-5">
    <div class="container max-w-800 mx-auto">
        <div class="text-center mb-5">
            <span class="badge bg-warning-subtle text-dark px-3 py-2 rounded-pill fw-bold text-uppercase">Online Verification Registry</span>
            <h2 class="fw-bold mt-2">Authenticity & Credential Verification</h2>
            <p class="text-muted">Enter the unique <strong>Certificate Number</strong> (e.g. CRT-2026-0001) or <strong>Verification Code</strong> printed on the student certificate.</p>
        </div>

        <!-- Search Form Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-5 bg-white">
            <form id="certVerifyForm" method="GET" action="{{ route('certificate.verify') }}">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-patch-check-fill text-primary"></i></span>
                    <input type="text" class="form-control border-start-0 bg-light fw-bold text-uppercase" id="verifyInput" name="code" value="{{ $searchCode }}" placeholder="Enter Certificate No. (e.g. CRT-2026-0001) or Code..." required>
                    <button class="btn btn-primary px-4 fw-bold" type="submit" id="btnVerify">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="verifySpinner" role="status"></span>
                        <i class="bi bi-search me-1"></i> Verify Now
                    </button>
                </div>
            </form>
        </div>

        <!-- Verification Result Target Container -->
        <div id="verifyResultContainer">
            @if($searched)
                @if($certificate)
                    @include('frontend.certificates._verification_card', ['certificate' => $certificate])
                @else
                    <div class="alert alert-danger shadow-sm rounded-4 p-4 text-center">
                        <i class="bi bi-x-circle-fill fs-1 d-block mb-2 text-danger"></i>
                        <h5 class="fw-bold">No Certificate Found</h5>
                        <p class="mb-0">We could not find any matching certificate record for code "<strong>{{ $searchCode }}</strong>". Please double check the number or contact institute administration.</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#certVerifyForm').on('submit', function(e) {
            e.preventDefault();
            const codeVal = $('#verifyInput').val().trim();
            if (!codeVal) return;

            const $btn = $('#btnVerify');
            const $spinner = $('#verifySpinner');
            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');

            $.ajax({
                url: "{{ route('certificate.verify') }}",
                type: "GET",
                data: { code: codeVal },
                success: function(res) {
                    $('#verifyResultContainer').html(res.html);
                },
                error: function() {
                    $('#verifyResultContainer').html(`
                        <div class="alert alert-danger shadow-sm rounded-4 p-4 text-center">
                            <i class="bi bi-x-circle-fill fs-1 d-block mb-2 text-danger"></i>
                            <h5 class="fw-bold">No Valid Certificate Found</h5>
                            <p class="mb-0">No matching certificate found for the entered credential. Please verify the code or contact support.</p>
                        </div>
                    `);
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
