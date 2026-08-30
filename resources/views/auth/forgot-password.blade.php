@extends('layouts.frontend')

@section('title', 'Reset Password')

@section('content')
<section class="py-5 bg-light d-flex align-items-center" style="min-height: 70vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white p-4 p-md-5 text-center">
                    <div class="bg-warning text-dark rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-key-fill fs-3"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">Forgot Password?</h4>
                    <p class="text-muted small mb-4">Contact your institute Super Admin to reset your account password, or request an emergency recovery code.</p>

                    <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-1"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
