@extends('layouts.frontend')

@section('title', 'Student Reviews & Success Stories')

@section('content')
<x-breadcrumb title="Student Reviews & Success Stories" :breadcrumbs="['Reviews' => route('testimonials')]" />

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($testimonials as $testi)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white d-flex flex-column">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $testi->photo ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80' }}" class="rounded-circle object-fit-cover" style="width: 56px; height: 56px;" alt="{{ $testi->name }}">
                            <div>
                                <h6 class="fw-bold text-dark mb-0">{{ $testi->name }}</h6>
                                <small class="text-muted">{{ $testi->designation ?: 'Alumni Student' }}</small>
                            </div>
                        </div>
                        <div class="text-warning mb-3">
                            @for($s = 0; $s < $testi->rating; $s++)
                                <i class="bi bi-star-fill"></i>
                            @endfor
                        </div>
                        <p class="text-muted small flex-grow-1">"{{ $testi->review }}"</p>
                        @if($testi->course)
                            <div class="pt-2 border-top">
                                <span class="badge bg-primary-subtle text-primary">{{ $testi->course->course_name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $testimonials->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
@endsection
