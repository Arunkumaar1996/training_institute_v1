@extends('layouts.admin')

@section('title', 'Trainer: ' . $trainer->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <div class="d-flex align-items-center gap-2">
            <h3 class="fw-bold text-dark mb-0">{{ $trainer->name }}</h3>
            <span class="badge bg-{{ $trainer->status ? 'success' : 'secondary' }} badge-chip">{{ $trainer->status ? 'Active' : 'Inactive' }}</span>
        </div>
        <p class="text-muted small mb-0">{{ $trainer->specialization }} • {{ $trainer->experience_years }} Years Experience</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.trainers.edit', $trainer->id) }}" class="btn btn-outline-primary rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit Profile
        </a>
        <a href="{{ route('admin.trainers.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white mb-4">
            <img src="{{ $trainer->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80' }}" class="rounded-circle mx-auto mb-3 object-fit-cover shadow" style="width: 120px; height: 120px;" alt="{{ $trainer->name }}">
            <h4 class="fw-bold text-dark mb-1">{{ $trainer->name }}</h4>
            <span class="badge bg-primary px-3 py-2 rounded-pill mb-3">{{ $trainer->specialization }}</span>

            <div class="text-start border-top pt-3 small text-muted d-flex flex-column gap-2">
                <div><strong>Mobile:</strong> {{ $trainer->mobile }}</div>
                <div><strong>Email:</strong> {{ $trainer->email ?: 'N/A' }}</div>
                <div><strong>Qualification:</strong> {{ $trainer->qualification ?: 'B.E Hardware' }}</div>
                <div><strong>Experience:</strong> {{ $trainer->experience_years }} Years</div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-primary mb-3">Trainer Biography & Field Experience</h5>
            <p class="text-muted leading-relaxed mb-3">{{ $trainer->bio ?: 'Master instructor specializing in board-level diagnostics, schematic tracing, and component level soldering.' }}</p>
            
            @if($trainer->skills)
                <h6 class="fw-bold text-dark mb-2">Key Skills:</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach(explode(',', $trainer->skills) as $sk)
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">{{ trim($sk) }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-primary mb-3">Batches Assigned</h5>
            <div class="row g-3">
                @forelse($trainer->batches as $tb)
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold text-dark mb-1">{{ $tb->batch_name }}</h6>
                            <small class="text-primary d-block">{{ $tb->course?->course_name }}</small>
                            <small class="text-muted">{{ $tb->days_schedule }} ({{ $tb->status }})</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small ps-3">No batches assigned to this instructor.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
