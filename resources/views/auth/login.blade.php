@extends('layouts.frontend')

@section('title', 'Sign In to Institute Management Portal')

@section('content')
<section class="py-5 bg-light d-flex align-items-center" style="min-height: 70vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <div class="bg-white text-primary rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-shield-lock-fill fs-3"></i>
                        </div>
                        <h4 class="fw-bold text-white mb-0">Management Portal Login</h4>
                        <small class="text-white-50">Admin, Staff & Trainer Sign In</small>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if ($errors->any())
                            <div class="alert alert-danger shadow-sm rounded-3 small">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="login_email" class="form-label fw-semibold">Email or Mobile Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" class="form-control bg-light" id="login_email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@institute.com or mobile">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label for="login_password" class="form-label fw-semibold">Password</label>
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot password?</a>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" class="form-control bg-light" id="login_password" name="password" required placeholder="••••••••">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="bi bi-eye"></i></button>
                                </div>
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label small" for="remember">Keep me logged in on this device</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Sign In to Dashboard
                            </button>
                        </form>
                    </div>

                    <div class="card-footer bg-light text-center py-3 border-0 small text-muted">
                        Technical Institute Portal • Authorized Access Only
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.getElementById('togglePassword')?.addEventListener('click', function() {
        const passInput = document.getElementById('login_password');
        const icon = this.querySelector('i');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
</script>
@endpush
