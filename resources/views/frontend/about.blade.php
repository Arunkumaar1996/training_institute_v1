@extends('layouts.frontend')

@section('title', 'About Our Institute | Vision, Faculty & Practical Labs')
@section('meta_description', 'About TechMaster Training Institute - India leading chip-level mobile and laptop repairing academy.')

@section('content')
<x-breadcrumb title="About Our Training Institute" :breadcrumbs="['About Us' => route('about')]" />

<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">Our Mission</span>
                <h2 class="fw-bold mb-3">Empowering Technical Skills Through Hands-on Precision Engineering</h2>
                <p class="text-muted leading-relaxed mb-3">
                    Founded with a passion for electronics hardware education, TechMaster Institute has trained over 5,000+ successful technicians and business owners across India. We believe technical mastery is achieved through hands-on microscope training, circuit tracing, and live device fault diagnostics.
                </p>
                <p class="text-muted leading-relaxed mb-4">
                    Our air-conditioned laboratories are equipped with industry-standard BGA rework stations, digital oscilloscopes, and specialized thermal imaging cameras to give students the highest level of technical confidence.
                </p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3 border-start border-primary border-4">
                            <h5 class="fw-bold text-dark mb-1">100% Practical</h5>
                            <small class="text-muted">Individual tool stations for every trainee.</small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded-3 border-start border-warning border-4">
                            <h5 class="fw-bold text-dark mb-1">Job & Business</h5>
                            <small class="text-muted">Direct vendor links & shop setup guidance.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-4 shadow-lg object-fit-cover" style="min-height: 380px;" alt="Practical Electronics Lab">
            </div>
        </div>
    </div>
</section>
@endsection
