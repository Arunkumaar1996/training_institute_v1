@extends('layouts.frontend')

@section('title', 'Master Technical Trainers & Faculty')

@section('content')
<x-breadcrumb title="Our Master Technical Trainers" :breadcrumbs="['Trainers' => route('trainers')]" />

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($trainers as $trainer)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 bg-white">
                        <img src="{{ $trainer->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80' }}" class="rounded-circle mx-auto mb-3 object-fit-cover shadow-sm" style="width: 110px; height: 110px;" alt="{{ $trainer->name }}">
                        <h5 class="fw-bold text-dark mb-1">{{ $trainer->name }}</h5>
                        <p class="text-primary small fw-semibold mb-2">{{ $trainer->specialization }}</p>
                        <p class="text-muted text-xs small mb-3">{{ $trainer->experience_years }}+ Years Field Experience</p>
                        <a href="{{ route('trainer.details', $trainer->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">View Full Bio</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $trainers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
@endsection
