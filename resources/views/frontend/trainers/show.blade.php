@extends('layouts.frontend')

@section('title', $trainer->name . ' - Master Trainer Profile')

@section('content')
<x-breadcrumb :title="$trainer->name" :breadcrumbs="['Trainers' => route('trainers'), $trainer->name => route('trainer.details', $trainer->id)]" />

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white">
                    <img src="{{ $trainer->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80' }}" class="rounded-circle mx-auto mb-3 object-fit-cover shadow" style="width: 140px; height: 140px;" alt="{{ $trainer->name }}">
                    <h4 class="fw-bold text-dark mb-1">{{ $trainer->name }}</h4>
                    <span class="badge bg-primary px-3 py-2 rounded-pill mb-3">{{ $trainer->specialization }}</span>
                    
                    <div class="text-start border-top pt-3 small text-muted d-flex flex-column gap-2">
                        <div><strong>Qualification:</strong> {{ $trainer->qualification ?: 'B.E Electronics & Hardware Eng.' }}</div>
                        <div><strong>Experience:</strong> {{ $trainer->experience_years }} Years Practical Field Experience</div>
                        <div><strong>Training Batches:</strong> {{ $trainer->batches->count() }} Batches Conducted</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3">About The Instructor</h5>
                    <p class="text-muted leading-relaxed">{{ $trainer->bio ?: 'Specialist instructor in micro-soldering, circuit tracing, logic board troubleshooting, and chip level component replacement.' }}</p>

                    @if($trainer->skills)
                        <h6 class="fw-bold text-dark mt-4 mb-2">Technical Skills & Expertise:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(explode(',', $trainer->skills) as $sk)
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">{{ trim($sk) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3">Batches Instructed by {{ $trainer->name }}</h5>
                    <div class="row g-3">
                        @forelse($trainer->batches as $tb)
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded-3 border">
                                    <h6 class="fw-bold text-dark mb-1">{{ $tb->batch_name }}</h6>
                                    <small class="text-primary d-block mb-1">{{ $tb->course?->course_name }}</small>
                                    <small class="text-muted"><i class="bi bi-clock me-1"></i> {{ $tb->days_schedule }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">No active batches assigned currently.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
