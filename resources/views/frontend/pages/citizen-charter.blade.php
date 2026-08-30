@extends('layouts.frontend')

@section('title', 'Citizen / Institute Charter')

@section('content')
<x-breadcrumb title="Citizen / Institute Charter" :breadcrumbs="['Citizen Charter' => route('page.show', 'citizen-charter')]" />

<section class="py-5 bg-white">
    <div class="container max-w-900 mx-auto">
        <article class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
            <h2 class="fw-bold text-primary mb-3">Citizen & Trainee Charter</h2>
            <p class="text-muted leading-relaxed">
                This charter outlines the standards of service, commitments, and responsibilities that <strong>{{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }}</strong> delivers to its students, trainees, and citizens.
            </p>

            <h5 class="fw-bold mt-4 mb-2 text-dark">Our Standards of Service:</h5>
            <ol class="text-muted leading-relaxed">
                <li><strong>Transparency in Fees:</strong> All course fees, installment options, and syllabus topics are published openly with zero hidden charges.</li>
                <li><strong>Individual Lab Workstations:</strong> Guaranteed access to working microscopes, BGA rework stations, digital multimeters, and test motherboards during all laboratory sessions.</li>
                <li><strong>Authorized Certification:</strong> Issue authentic, verifiable completion certificates with QR code verification within 7 business days of course completion.</li>
                <li><strong>Lifetime Technical Support:</strong> Lifetime assistance via our dedicated Telegram & WhatsApp technical discussion forums for troubleshooting challenging device circuit faults.</li>
            </ol>

            <h5 class="fw-bold mt-4 mb-2 text-dark">Grievance Redressal:</h5>
            <p class="text-muted">
                Any student grievance can be submitted via the contact form or directly to the Institute Director at <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'aruntech1996@gmail.com') }}">{{ \App\Models\Setting::get('contact_email', 'aruntech1996@gmail.com') }}</a>. All formal grievances are resolved within 5 working days.
            </p>
        </article>
    </div>
</section>
@endsection
