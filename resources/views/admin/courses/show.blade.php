@extends('layouts.admin')

@section('title', 'Course: ' . $course->course_name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">{{ $course->course_name }}</h3>
        <p class="text-muted small mb-0">Code: {{ $course->course_code }} • Category: {{ $course->category?->name ?? 'General' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-outline-primary rounded-pill px-3">
            <i class="bi bi-pencil me-1"></i> Edit Course
        </a>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Course Info Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
            <img src="{{ $course->image ?: 'https://images.unsplash.com/photo-1597740985671-2a8a3b80532e?auto=format&fit=crop&w=600&q=80' }}" class="card-img-top object-fit-cover" style="height: 180px;" alt="{{ $course->course_name }}">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-primary">{{ $course->level }}</span>
                    <span class="badge bg-{{ $course->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($course->status) }}</span>
                </div>
                <h5 class="fw-bold text-primary mb-1">Fee: ₹{{ number_format($course->final_fee) }}</h5>
                <small class="text-muted d-block mb-3">Standard: ₹{{ number_format($course->course_fee) }} (Discount: ₹{{ number_format($course->discount_fee) }})</small>

                <div class="small text-muted border-top pt-3 d-flex flex-column gap-2">
                    <div><strong>Duration:</strong> {{ $course->duration }} {{ $course->duration_unit }}</div>
                    <div><strong>Active Batches:</strong> {{ $course->batches->count() }} Batches</div>
                    <div><strong>Total Admissions:</strong> {{ $course->admissions->count() }} Students</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Syllabus Modules Builder -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-primary mb-0"><i class="bi bi-journal-text me-2"></i> Course Syllabus Modules</h5>
                <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="collapse" data-bs-target="#addModuleCollapse">
                    <i class="bi bi-plus-circle me-1"></i> Add Module
                </button>
            </div>

            <!-- Add Module Collapse Form -->
            <div class="collapse mb-4" id="addModuleCollapse">
                <form method="POST" action="{{ route('admin.courses.syllabus.store', $course->id) }}" class="p-3 bg-light rounded-3 border">
                    @csrf
                    <h6 class="fw-bold text-dark mb-3">New Syllabus Module</h6>
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Module No.</label>
                            <input type="number" name="module_number" class="form-control form-control-sm rounded-3" value="{{ ($course->syllabi->max('module_number') ?? 0) + 1 }}" required>
                        </div>
                        <div class="col-md-9">
                            <label class="form-label small fw-semibold">Module Title</label>
                            <input type="text" name="title" class="form-control form-control-sm rounded-3" required placeholder="e.g. SMD Components & Micro-Soldering Techniques">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Description</label>
                            <textarea name="description" class="form-control form-control-sm rounded-3" rows="2" placeholder="Brief outline of this module..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Topics (One per line)</label>
                            <textarea name="topics" class="form-control form-control-sm rounded-3" rows="3" placeholder="• Multimeter testing&#10;• Mosfet identification&#10;• BGA reballing"></textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-4">Save Module</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modules List -->
            <div class="d-flex flex-column gap-3">
                @forelse($course->syllabi as $mod)
                    <div class="p-3 bg-light rounded-3 border d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary text-xs">Module {{ $mod->module_number }}</span>
                                <h6 class="fw-bold text-dark mb-0">{{ $mod->title }}</h6>
                            </div>
                            @if($mod->description)<p class="text-muted small mb-2">{{ $mod->description }}</p>@endif
                            @if($mod->topics)
                                <div class="p-2 bg-white rounded border small text-dark">{!! nl2br(e($mod->topics)) !!}</div>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('admin.courses.syllabus.delete', [$course->id, $mod->id]) }}" onsubmit="return confirm('Delete this module?');" class="ms-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        No syllabus modules added yet. Click "Add Module" to build the curriculum.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
