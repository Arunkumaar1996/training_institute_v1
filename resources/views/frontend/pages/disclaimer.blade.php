@extends('layouts.frontend')

@section('title', 'Disclaimer')

@section('content')
<x-breadcrumb title="Website Disclaimer" :breadcrumbs="['Disclaimer' => route('page.show', 'disclaimer')]" />

<section class="py-5 bg-white">
    <div class="container max-w-900 mx-auto">
        <article class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
            <h2 class="fw-bold text-primary mb-3">Disclaimer</h2>
            <p class="text-muted leading-relaxed">
                The content published on this website is for educational and general informational purposes regarding technical training courses in mobile and laptop hardware engineering. While every effort is made to keep course syllabus and batch schedules accurate and current, {{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }} reserves the right to make modifications in syllabus modules, batch timings, and faculty allocations as required.
            </p>
        </article>
    </div>
</section>
@endsection
