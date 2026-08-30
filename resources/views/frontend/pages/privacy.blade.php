@extends('layouts.frontend')

@section('title', 'Privacy Policy')

@section('content')
<x-breadcrumb title="Privacy Policy" :breadcrumbs="['Privacy Policy' => route('page.show', 'privacy')]" />

<section class="py-5 bg-white">
    <div class="container max-w-900 mx-auto">
        <article class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
            <h2 class="fw-bold text-primary mb-3">Privacy Policy</h2>
            <p class="text-muted leading-relaxed">
                Your privacy is paramount. This Privacy Policy details the types of personal information collected through our website and how it is secured.
            </p>

            <h5 class="fw-bold mt-4 mb-2 text-dark">Information Collection:</h5>
            <p class="text-muted leading-relaxed">
                When you submit an online enquiry, admission form, or contact message, we collect your name, mobile number, email address, and educational qualifications. This data is strictly used for admissions processing, communication regarding class schedules, fee receipts, and certificate verification.
            </p>

            <h5 class="fw-bold mt-4 mb-2 text-dark">Data Security & Non-Disclosure:</h5>
            <p class="text-muted leading-relaxed">
                We never sell, rent, or trade student personal records or contact information to third-party marketing companies. Data is protected with SSL encryption, hashed credentials, and strict database access controls.
            </p>
        </article>
    </div>
</section>
@endsection
