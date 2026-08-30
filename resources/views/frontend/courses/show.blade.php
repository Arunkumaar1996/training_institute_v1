@extends('layouts.frontend')

@section('title', $course->seo_title ?: $course->course_name . ' Training Course')
@section('meta_description', $course->seo_description ?: Str::limit($course->short_description, 160))
@section('meta_keywords', $course->seo_keywords ?: 'mobile repair course, laptop hardware, ' . $course->course_name)

@section('content')
<x-breadcrumb :title="$course->course_name" :breadcrumbs="['Courses' => route('courses'), $course->course_name => route('course.details', $course->slug)]" />

<section class="py-4">
    <div class="container">
        <div class="row g-4">
            <!-- Left Course Overview & Syllabus -->
            <div class="col-lg-8">
                <!-- Course Main Header Banner -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
                    <img src="{{ $course->image ?: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1200&q=80' }}" class="card-img-top object-fit-cover" style="max-height: 360px;" alt="{{ $course->course_name }}">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <span class="badge bg-primary px-3 py-2 rounded-pill">{{ $course->level }}</span>
                            <span class="badge bg-dark px-3 py-2 rounded-pill"><i class="bi bi-clock me-1"></i> {{ $course->duration }} {{ $course->duration_unit }}</span>
                            <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-patch-check me-1"></i> ISO Certified</span>
                        </div>
                        <h2 class="fw-bold text-dark mb-3">{{ $course->course_name }}</h2>
                        <p class="text-muted leading-relaxed">{{ $course->full_description ?: $course->short_description }}</p>
                    </div>
                </div>

                <!-- Syllabus Accordion -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <h4 class="fw-bold text-dark mb-3"><i class="bi bi-journal-text text-primary me-2"></i> Comprehensive Course Syllabus</h4>
                    <p class="text-muted small mb-4">Module-by-module breakdown of practical hands-on topics covered in this training program.</p>

                    @if($course->syllabi->isNotEmpty())
                        <div class="accordion" id="syllabusAccordion">
                            @foreach($course->syllabi as $index => $mod)
                                <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                                    <h2 class="accordion-header" id="modHeading{{ $mod->id }}">
                                        <button class="accordion-button fw-bold {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#modCollapse{{ $mod->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                            <span class="badge bg-primary me-3">Module {{ $mod->module_number }}</span>
                                            {{ $mod->title }}
                                        </button>
                                    </h2>
                                    <div id="modCollapse{{ $mod->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#syllabusAccordion">
                                        <div class="accordion-body text-muted small lh-lg">
                                            @if($mod->description)
                                                <p class="mb-2">{{ $mod->description }}</p>
                                            @endif
                                            @if($mod->topics)
                                                <div class="p-3 bg-light rounded-3">
                                                    <h6 class="fw-bold text-dark mb-2">Key Practical Topics:</h6>
                                                    <div class="text-dark small">{!! nl2br(e($mod->topics)) !!}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 bg-light rounded-3 text-center">
                            <p class="text-muted mb-0">Detailed syllabus module outline is updated regularly. Contact us for the complete PDF curriculum.</p>
                        </div>
                    @endif
                </div>

                <!-- Learning Outcomes & Prerequisites -->
                @if($course->learning_outcomes || $course->requirements)
                    <div class="row g-4 mb-4">
                        @if($course->learning_outcomes)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                                    <h5 class="fw-bold text-success mb-3"><i class="bi bi-check2-circle me-2"></i> What You'll Learn</h5>
                                    <div class="text-muted small lh-lg">{!! nl2br(e($course->learning_outcomes)) !!}</div>
                                </div>
                            </div>
                        @endif
                        @if($course->requirements)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                                    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-card-checklist me-2"></i> Prerequisites</h5>
                                    <div class="text-muted small lh-lg">{!! nl2br(e($course->requirements)) !!}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Right Sidebar: Fee, Enrollment & Upcoming Batches -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Fee Card -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                        <span class="text-muted small text-uppercase fw-semibold">Course Investment</span>
                        <div class="d-flex align-items-baseline flex-wrap gap-2 my-2">
                            <h3 class="fw-black text-primary mb-0 fs-2 text-nowrap">₹{{ number_format($course->final_fee) }}</h3>
                            @if($course->discount_fee > 0)
                                <span class="text-muted text-decoration-line-through fs-6 text-nowrap">₹{{ number_format($course->course_fee) }}</span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill fw-semibold text-nowrap">Save ₹{{ number_format($course->discount_fee) }}</span>
                            @endif
                        </div>
                        <p class="text-muted small mb-4"><i class="bi bi-credit-card-2-front me-1"></i> Easy 2-3 installment payment options available.</p>

                        <div class="d-grid gap-2">
                            <a href="{{ route('admission') }}" class="btn btn-warning btn-lg fw-bold text-dark rounded-pill shadow-sm">
                                <i class="bi bi-pencil-square me-1"></i> Apply Online Now
                            </a>
                            <button type="button" class="btn btn-outline-primary btn-lg rounded-pill" data-bs-toggle="modal" data-bs-target="#enquiryModal">
                                <i class="bi bi-chat-left-dots me-1"></i> Enquire About Batch
                            </button>
                            @if($course->brochure_file)
                                <a href="{{ $course->brochure_file }}" download class="btn btn-light rounded-pill border small">
                                    <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> Download Syllabus PDF
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Upcoming Batches Widget -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-calendar-check text-primary me-2"></i> Upcoming Batches</h5>
                        @if($course->batches->isNotEmpty())
                            <div class="d-flex flex-column gap-3">
                                @foreach($course->batches as $batch)
                                    <div class="p-3 bg-light rounded-3 border">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <strong class="text-dark small">{{ $batch->batch_name }}</strong>
                                            <span class="badge bg-{{ $batch->status === 'Upcoming' ? 'info' : 'success' }} badge-chip">{{ $batch->status }}</span>
                                        </div>
                                        <div class="text-muted text-xs small">
                                            <div><i class="bi bi-calendar-event me-1"></i> Starts: {{ $batch->start_date->format('d M Y') }}</div>
                                            <div><i class="bi bi-clock me-1"></i> Timing: {{ $batch->start_time ? date('h:i A', strtotime($batch->start_time)) : 'Morning' }} - {{ $batch->end_time ? date('h:i A', strtotime($batch->end_time)) : 'Batch' }}</div>
                                            <div><i class="bi bi-geo-alt me-1"></i> Mode: {{ $batch->mode }} (Room: {{ $batch->room_number ?? 'Lab 1' }})</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small mb-0">New batches starting every Monday. Contact counselors for exact timings.</p>
                        @endif
                    </div>

                    <!-- Helpline Card -->
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-primary text-white text-center">
                        <p class="small mb-2">Have questions or want a free demo class?</p>
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-telephone-fill me-1"></i> {{ \App\Models\Setting::get('contact_phone', '+91 7418191487') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
