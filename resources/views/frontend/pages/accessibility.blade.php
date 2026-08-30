@extends('layouts.frontend')

@section('title', 'Accessibility Statement - GIGW 3.0 & WCAG 2.1 AA')

@section('content')
<x-breadcrumb title="Accessibility Statement" :breadcrumbs="['Accessibility' => route('page.show', 'accessibility')]" />

<section class="py-5 bg-white">
    <div class="container max-w-900 mx-auto">
        <article class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
            <h2 class="fw-bold text-primary mb-3">Accessibility Statement for {{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }}</h2>
            <p class="text-muted leading-relaxed">
                We are committed to ensuring that our website is accessible to all individuals, including people with disabilities, in compliance with the <strong>Guidelines for Indian Government Websites (GIGW 3.0)</strong> and World Wide Web Consortium (W3C) <strong>Web Content Accessibility Guidelines (WCAG) 2.1 Level AA</strong>.
            </p>

            <h5 class="fw-bold mt-4 mb-2 text-dark">Accessibility Features Provided:</h5>
            <ul class="text-muted leading-relaxed">
                <li><strong>Text Resizing Controls:</strong> Buttons (A-, A, A+) are provided in the top accessibility toolbar to easily enlarge or reduce text sizes across the whole portal without breaking layouts.</li>
                <li><strong>High Contrast & Dark Mode:</strong> A dedicated High Contrast (Yellow-on-Black) and Dark mode toggle are provided to aid visually impaired and photophobic users.</li>
                <li><strong>Skip to Main Content:</strong> Direct keyboard shortcut landmark allowing screen-reader users and keyboard-only navigators to bypass navigation menus directly to the main body content (`#main-content`).</li>
                <li><strong>Keyboard Focus Indicators:</strong> High visibility outline rings highlight active interactive elements when tabbing through web pages.</li>
                <li><strong>Semantic HTML5 Structure:</strong> Proper landmark tags (`<header>`, `<nav>`, `<main>`, `<section>`, `<footer>`) ensure clear auditory navigation for assistive screen reader software (NVDA, JAWS, VoiceOver).</li>
                <li><strong>Alternative Text (Alt Text):</strong> All informative images include descriptive alternative text tags.</li>
            </ul>

            <h5 class="fw-bold mt-4 mb-2 text-dark">Feedback & Assistance:</h5>
            <p class="text-muted">
                If you encounter any difficulty accessing any part of this website or require content in an alternative accessible format, please contact our Accessibility Officer at <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'aruntech1996@gmail.com') }}">{{ \App\Models\Setting::get('contact_email', 'aruntech1996@gmail.com') }}</a>.
            </p>
        </article>
    </div>
</section>
@endsection
