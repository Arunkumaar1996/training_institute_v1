@extends('layouts.frontend')

@section('title', 'Website Sitemap')

@section('content')
<x-breadcrumb title="Website Sitemap" :breadcrumbs="['Sitemap' => route('page.show', 'sitemap')]" />

<section class="py-5 bg-white">
    <div class="container max-w-900 mx-auto">
        <div class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
            <h2 class="fw-bold text-primary mb-4">Complete Website Navigation Sitemap</h2>

            <div class="row g-4">
                <div class="col-md-6">
                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">Main Website Pages</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 text-muted">
                        <li><a href="{{ route('home') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Home Page</a></li>
                        <li><a href="{{ route('about') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> About Us</a></li>
                        <li><a href="{{ route('courses') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Courses Catalog</a></li>
                        <li><a href="{{ route('trainers') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Trainers Directory</a></li>
                        <li><a href="{{ route('testimonials') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Student Reviews & Testimonials</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Lab & Workshop Gallery</a></li>
                        <li><a href="{{ route('faq') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Frequently Asked Questions</a></li>
                        <li><a href="{{ route('blog') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Technical Articles & News</a></li>
                        <li><a href="{{ route('contact') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Contact Us</a></li>
                    </ul>
                </div>

                <div class="col-md-6">
                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">Student & Compliance Links</h5>
                    <ul class="list-unstyled d-flex flex-column gap-2 text-muted">
                        <li><a href="{{ route('admission') }}" class="text-decoration-none text-warning fw-bold"><i class="bi bi-chevron-right text-warning me-2"></i> Online Student Admission</a></li>
                        <li><a href="{{ route('certificate.verify') }}" class="text-decoration-none text-primary fw-bold"><i class="bi bi-chevron-right text-primary me-2"></i> Certificate Verification Registry</a></li>
                        <li><a href="{{ route('login') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Staff / Student Login Portal</a></li>
                        <li><a href="{{ route('page.show', 'accessibility') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Accessibility Statement (GIGW 3.0)</a></li>
                        <li><a href="{{ route('page.show', 'citizen-charter') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Citizen / Institute Charter</a></li>
                        <li><a href="{{ route('page.show', 'privacy') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Privacy Policy</a></li>
                        <li><a href="{{ route('page.show', 'terms') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Terms & Conditions</a></li>
                        <li><a href="{{ route('page.show', 'disclaimer') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Disclaimer</a></li>
                        <li><a href="{{ route('page.show', 'hyperlinking-policy') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Hyperlinking Policy</a></li>
                        <li><a href="{{ route('page.show', 'copyright') }}" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-primary me-2"></i> Copyright Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
