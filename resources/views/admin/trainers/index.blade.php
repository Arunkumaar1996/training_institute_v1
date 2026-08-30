@extends('layouts.admin')

@section('title', 'Trainers & Faculty')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Technical Trainers & Faculty</h3>
        <p class="text-muted small mb-0">Manage certified electronics instructors and course allocations</p>
    </div>
    <a href="{{ route('admin.trainers.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
        <i class="bi bi-person-plus-fill me-1"></i> Add Trainer
    </a>
</div>

<div class="row g-4">
    @forelse($trainers as $t)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white d-flex flex-column">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="{{ $t->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80' }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 58px; height: 58px;" alt="{{ $t->name }}">
                    <div>
                        <a href="{{ route('admin.trainers.show', $t->id) }}" class="fw-bold text-dark text-decoration-none d-block fs-6">{{ $t->name }}</a>
                        <small class="text-primary fw-semibold">{{ $t->specialization }}</small>
                    </div>
                </div>

                <div class="small text-muted mb-3 flex-grow-1 d-flex flex-column gap-1">
                    <div><i class="bi bi-telephone me-1"></i> {{ $t->mobile }}</div>
                    <div><i class="bi bi-briefcase me-1"></i> {{ $t->experience_years }} Years Field Experience</div>
                    <div><i class="bi bi-calendar3-range me-1"></i> {{ $t->batches_count }} Batches Conducted</div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                    <span class="badge bg-{{ $t->status ? 'success' : 'secondary' }} badge-chip">
                        {{ $t->status ? 'Active' : 'Inactive' }}
                    </span>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.trainers.show', $t->id) }}" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('admin.trainers.edit', $t->id) }}" class="btn btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">No trainer profiles created yet.</div>
    @endforelse
</div>
@endsection
