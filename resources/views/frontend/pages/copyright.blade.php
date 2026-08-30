@extends('layouts.frontend')

@section('title', 'Copyright Policy')

@section('content')
<x-breadcrumb title="Copyright Policy" :breadcrumbs="['Copyright' => route('page.show', 'copyright')]" />

<section class="py-5 bg-white">
    <div class="container max-w-900 mx-auto">
        <article class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
            <h2 class="fw-bold text-primary mb-3">Copyright Policy</h2>
            <p class="text-muted leading-relaxed">
                The technical curriculum, syllabus design, practical training methodologies, and proprietary learning materials featured on this website are the intellectual property of <strong>{{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }}</strong>.
            </p>
            <p class="text-muted leading-relaxed">
                Content may not be reproduced, retransmitted, published, or commercially exploited without explicit written authorization from institute management.
            </p>
        </article>
    </div>
</section>
@endsection
