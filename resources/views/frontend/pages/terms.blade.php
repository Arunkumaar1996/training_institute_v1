@extends('layouts.frontend')

@section('title', 'Terms & Conditions')

@section('content')
<x-breadcrumb title="Terms & Conditions" :breadcrumbs="['Terms & Conditions' => route('page.show', 'terms')]" />

<section class="py-5 bg-white">
    <div class="container max-w-900 mx-auto">
        <article class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
            <h2 class="fw-bold text-primary mb-3">Terms & Conditions</h2>
            <p class="text-muted leading-relaxed">
                By enrolling in courses or using this web portal, you agree to adhere to the rules and policies of {{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }}.
            </p>

            <h5 class="fw-bold mt-4 mb-2 text-dark">Course Enrollment & Attendance:</h5>
            <p class="text-muted leading-relaxed">
                Students are required to maintain a minimum of 75% practical lab attendance to be eligible for the course completion examination and formal certificate generation.
            </p>

            <h5 class="fw-bold mt-4 mb-2 text-dark">Fee Payments & Receipts:</h5>
            <p class="text-muted leading-relaxed">
                Course fees paid in installments must be cleared by the designated due dates. An official computer-generated receipt is issued for every transaction.
            </p>
        </article>
    </div>
</section>
@endsection
