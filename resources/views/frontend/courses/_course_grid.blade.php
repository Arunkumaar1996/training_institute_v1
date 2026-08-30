<div class="row g-4" id="coursesListContainer">
    @forelse($courses as $course)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 course-card bg-white overflow-hidden d-flex flex-column">
                <div class="position-relative">
                    <img src="{{ $course->image ?: 'https://images.unsplash.com/photo-1597740985671-2a8a3b80532e?auto=format&fit=crop&w=600&q=80' }}" class="card-img-top object-fit-cover" style="height: 200px;" alt="{{ $course->course_name }}">
                    <span class="position-absolute top-0 start-0 m-3 badge bg-primary badge-chip">{{ $course->level }}</span>
                    <span class="position-absolute top-0 end-0 m-3 badge bg-dark badge-chip"><i class="bi bi-clock"></i> {{ $course->duration }} {{ $course->duration_unit }}</span>
                </div>
                <div class="card-body p-4 d-flex flex-column flex-grow-1">
                    <small class="text-primary fw-semibold text-uppercase mb-1">{{ $course->category?->name ?? 'Repair Course' }}</small>
                    <h5 class="card-title fw-bold text-dark mb-2">
                        <a href="{{ route('course.details', $course->slug) }}" class="text-decoration-none text-dark">{{ $course->course_name }}</a>
                    </h5>
                    <p class="card-text text-muted small mb-4 flex-grow-1">
                        {{ Str::limit($course->short_description, 95) }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                        <div>
                            @if($course->discount_fee > 0)
                                <span class="text-muted text-decoration-line-through small me-1">₹{{ number_format($course->course_fee) }}</span>
                            @endif
                            <span class="fs-5 fw-bold text-primary">₹{{ number_format($course->final_fee) }}</span>
                        </div>
                        <a href="{{ route('course.details', $course->slug) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-semibold">
                            View Course <i class="bi bi-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="p-4 bg-light rounded-4">
                <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
                <h5 class="fw-bold">No Courses Found</h5>
                <p class="text-muted small">Try adjusting your filters or search keywords.</p>
                <a href="{{ route('courses') }}" class="btn btn-sm btn-primary rounded-pill px-3">Reset Filters</a>
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $courses->links('pagination::bootstrap-5') }}
</div>
