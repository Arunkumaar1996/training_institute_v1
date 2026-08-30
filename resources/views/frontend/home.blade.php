@extends('layouts.frontend')

@section('title', 'Best Mobile & Laptop Repair Training Institute | Chip Level Courses')

@section('content')
<!-- Hero Section -->
<section class="hero-banner text-white py-5 py-lg-6 position-relative overflow-hidden">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-center text-lg-start">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 shadow-sm">
                    <i class="bi bi-award-fill me-1"></i> #1 Technical Training Academy in India
                </span>
                <h1 class="display-4 fw-black mb-3 lh-sm">
                    Master <span class="text-warning">Mobile & Laptop</span> Chip-Level Repairing
                </h1>
                <p class="lead text-white-50 mb-4 fs-5">
                    Transform into a certified hardware & chip-level engineer. 100% hands-on practical lab training from basic electronics to advanced BGA IC reballing, schematics reading, and motherboard fault finding.
                </p>
                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-2 gap-sm-3 mb-4">
                    <a href="{{ route('admission') }}" class="btn btn-warning btn-lg px-4 py-3 rounded-pill fw-bold text-dark shadow">
                        <i class="bi bi-person-check-fill me-2"></i> Enroll For New Batch
                    </a>
                    <button type="button" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-semibold" data-bs-toggle="modal" data-bs-target="#enquiryModal">
                        <i class="bi bi-calendar-event me-2"></i> Free Demo Class
                    </button>
                    <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+917418191487') }}" class="btn btn-light btn-lg px-4 py-3 rounded-pill fw-semibold text-primary shadow-sm d-none d-sm-inline-flex">
                        <i class="bi bi-telephone-fill me-2"></i> Call Helpline
                    </a>
                </div>
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-2 gap-sm-3 flex-wrap text-white-50 small">
                    <span class="badge bg-white-10 text-light border border-white-50 py-2 px-3 rounded-pill"><i class="bi bi-check-circle-fill text-warning me-1"></i> ISO Certified</span>
                    <span class="badge bg-white-10 text-light border border-white-50 py-2 px-3 rounded-pill"><i class="bi bi-check-circle-fill text-warning me-1"></i> 100% Practical</span>
                    <span class="badge bg-white-10 text-light border border-white-50 py-2 px-3 rounded-pill"><i class="bi bi-check-circle-fill text-warning me-1"></i> Placement Support</span>
                </div>
            </div>

            <!-- Quick Lead Form Card on Hero -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-2-strong rounded-4 overflow-hidden bg-white text-dark p-4">
                    <div class="card-body p-0">
                        <h4 class="fw-bold text-primary mb-1">Get Instant Course Details</h4>
                        <p class="text-muted small mb-3">Fill this form to receive complete syllabus and batch timings.</p>
                        
                        <form id="heroLeadForm" action="{{ route('enquiry.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Your Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control rounded-3" required placeholder="Enter full name">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" name="mobile" class="form-control rounded-3" required placeholder="10-digit mobile number">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Select Course</label>
                                <select name="course_id" class="form-select rounded-3">
                                    <option value="">-- Choose Course --</option>
                                    @foreach($featuredCourses as $fc)
                                        <option value="{{ $fc->id }}">{{ $fc->course_name }} ({{ $fc->level }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm">
                                <i class="bi bi-send-fill me-1"></i> Request Course Brochure
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Stats Counter Row -->
<section class="bg-white py-4 shadow-sm border-bottom overflow-hidden">
    <div class="container">
        <div class="row g-3 g-md-4 text-center">
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <h2 class="display-6 fw-bold text-primary mb-0">{{ $stats['students_trained'] }}</h2>
                    <span class="text-muted small fw-medium">Students Trained & Certified</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <h2 class="display-6 fw-bold text-warning mb-0">{{ $stats['placement_rate'] }}</h2>
                    <span class="text-muted small fw-medium">Placement & Self-Employment</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <h2 class="display-6 fw-bold text-success mb-0">{{ $stats['active_courses'] }}+</h2>
                    <span class="text-muted small fw-medium">Specialized Courses</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-2">
                    <h2 class="display-6 fw-bold text-info mb-0">{{ $stats['experience_years'] }}</h2>
                    <span class="text-muted small fw-medium">Years Academic Excellence</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Course Categories Section -->
<section class="py-5 bg-light overflow-hidden">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold text-uppercase">Training Domains</span>
            <h2 class="fw-bold mt-2">Comprehensive Basic to Advanced Domains</h2>
            <p class="text-muted">Explore our dynamic industry-aligned technical courses crafted for high-demand careers.</p>
        </div>

        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('courses', ['category' => $category->slug]) }}" class="card h-100 border-0 shadow-sm rounded-4 text-decoration-none p-3 text-center transition-all bg-white hover-shadow">
                        <div class="bg-primary-subtle text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi {{ $category->icon ?: 'bi-cpu-fill' }} fs-3"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">{{ $category->name }}</h6>
                        <span class="badge bg-light text-muted border rounded-pill">{{ $category->courses_count }} Courses</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<section class="py-5 bg-white overflow-hidden">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-5">
            <div>
                <span class="badge bg-warning-subtle text-dark px-3 py-2 rounded-pill fw-bold text-uppercase">Featured Programs</span>
                <h2 class="fw-bold mt-2 mb-0">Most Popular Technical Courses</h2>
            </div>
            <a href="{{ route('courses') }}" class="btn btn-outline-primary rounded-pill px-4">
                View All Courses <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredCourses as $course)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 course-card bg-white overflow-hidden d-flex flex-column">
                        <div class="position-relative overflow-hidden">
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
                                    <span class="text-muted text-decoration-line-through small me-1">₹{{ number_format($course->course_fee) }}</span>
                                    <span class="fs-5 fw-bold text-primary">₹{{ number_format($course->final_fee) }}</span>
                                </div>
                                <a href="{{ route('course.details', $course->slug) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill fw-semibold">
                                    Details <i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose Us & Methodology Section -->
<section class="py-5 bg-light overflow-hidden">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">Why Study With Us</span>
                <h2 class="fw-bold mb-4">India's Most Advanced Practical Training Infrastructure</h2>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="bg-primary text-white rounded-3 p-2 px-3 fs-5 flex-shrink-0"><i class="bi bi-tools"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">100% Practical Lab with Individual Workstations</h6>
                            <p class="text-muted small mb-0">Every student gets hands-on access to digital oscilloscopes, microscope, hot air rework stations, DC power supply, and BGA reballing stations.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-start">
                        <div class="bg-warning text-dark rounded-3 p-2 px-3 fs-5 flex-shrink-0"><i class="bi bi-diagram-3-fill"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Schematic Diagrams & Motherboard Tracing</h6>
                            <p class="text-muted small mb-0">Master ZXW, Borneo Schematics, Pragmafix, and board view diagrams to trace short circuits, power rails, and logic boards effortlessly.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-start">
                        <div class="bg-success text-white rounded-3 p-2 px-3 fs-5 flex-shrink-0"><i class="bi bi-patch-check-fill"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Government & ISO Recognised Certification</h6>
                            <p class="text-muted small mb-0">Receive authentic verifiable certificates along with lifetime technical assistance and vendor supply connections for repair business startup.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-primary text-white p-4 p-lg-5 position-relative">
                    <h3 class="fw-bold mb-3">Our 4-Step Learning Methodology</h3>
                    <ul class="list-unstyled d-flex flex-column gap-3 mb-4">
                        <li class="d-flex align-items-start gap-3">
                            <span class="badge bg-warning text-dark rounded-circle fs-6 p-2 flex-shrink-0" style="width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">1</span>
                            <span><strong>Fundamentals & Testing:</strong> Resistors, Capacitors, Diodes, Mosfets, Multimeter testing.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <span class="badge bg-warning text-dark rounded-circle fs-6 p-2 flex-shrink-0" style="width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">2</span>
                            <span><strong>Schematic Tracing:</strong> Power sequences, voltage line shorts, PMIC, CPU, eMMC lines.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <span class="badge bg-warning text-dark rounded-circle fs-6 p-2 flex-shrink-0" style="width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">3</span>
                            <span><strong>Live IC Micro-Soldering:</strong> BGA IC removal, cleaning, stencil reballing, jumpering.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <span class="badge bg-warning text-dark rounded-circle fs-6 p-2 flex-shrink-0" style="width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;">4</span>
                            <span><strong>Real-world Troubleshooting:</strong> Live dead phones, no display, charging errors, network IC faults.</span>
                        </li>
                    </ul>
                    <a href="{{ route('admission') }}" class="btn btn-warning fw-bold text-dark py-2 px-4 rounded-pill align-self-start shadow">
                        Join Upcoming Batch
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Expert Trainers Showcase -->
<section class="py-5 bg-white overflow-hidden">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold text-uppercase">Faculty</span>
            <h2 class="fw-bold mt-2">Learn from Master Technical Trainers</h2>
            <p class="text-muted">Our instructors bring 10+ years of active field experience in authorized service centers and micro-soldering labs.</p>
        </div>

        <div class="row g-4">
            @foreach($trainers as $trainer)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center p-4 bg-light">
                        <img src="{{ $trainer->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=300&q=80' }}" class="rounded-circle mx-auto mb-3 object-fit-cover shadow-sm" style="width: 100px; height: 100px;" alt="{{ $trainer->name }}">
                        <h5 class="fw-bold text-dark mb-1">{{ $trainer->name }}</h5>
                        <p class="text-primary small fw-semibold mb-2">{{ $trainer->specialization }}</p>
                        <p class="text-muted text-xs small mb-3">{{ $trainer->experience_years }}+ Years Experience</p>
                        <a href="{{ route('trainer.details', $trainer->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">View Profile</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Student Testimonials & Success Stories -->
<section class="py-5 bg-light overflow-hidden">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <span class="badge bg-warning-subtle text-dark px-3 py-2 rounded-pill fw-bold text-uppercase">Success Stories</span>
            <h2 class="fw-bold mt-2">What Our Successful Alumni Say</h2>
            <p class="text-muted">Hundreds of our graduates now run their own profitable repair centers or work in top electronics firms.</p>
        </div>

        <div class="row g-4">
            @foreach($testimonials as $testi)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 bg-white d-flex flex-column">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $testi->photo ?: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80' }}" class="rounded-circle object-fit-cover flex-shrink-0" style="width: 54px; height: 54px;" alt="{{ $testi->name }}">
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
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-white overflow-hidden">
    <div class="container mx-auto" style="max-width: 900px;">
        <div class="text-center mb-5">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold text-uppercase">Got Questions?</span>
            <h2 class="fw-bold mt-2">Frequently Asked Questions</h2>
        </div>

        <div class="accordion shadow-sm rounded-4 overflow-hidden" id="homeFaqAccordion">
            @foreach($faqs as $faqIndex => $faqItem)
                <div class="accordion-item border-0 border-bottom">
                    <h3 class="accordion-header" id="heading{{ $faqItem->id }}">
                        <button class="accordion-button fw-semibold {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faqItem->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $faqItem->id }}">
                            {{ $faqItem->question }}
                        </button>
                    </h3>
                    <div id="collapse{{ $faqItem->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $faqItem->id }}" data-bs-parent="#homeFaqAccordion">
                        <div class="accordion-body text-muted small lh-lg">
                            {{ $faqItem->answer }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Dynamic Admission Call To Action Banner -->
<section class="py-5 bg-warning text-dark text-center overflow-hidden">
    <div class="container py-3">
        <h2 class="display-6 fw-black mb-3">Ready to Launch Your Technical Engineering Career?</h2>
        <p class="lead mb-4 fw-medium text-dark-emphasis mx-auto" style="max-width: 700px;">
            Limited seats available per batch for personalized microscope & tool workstation attention. Book your seat today!
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('admission') }}" class="btn btn-dark btn-lg px-4 py-3 rounded-pill fw-bold shadow">
                <i class="bi bi-pencil-square me-2"></i> Apply for Online Admission
            </a>
            <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+917418191487') }}" class="btn btn-outline-dark btn-lg px-4 py-3 rounded-pill fw-bold">
                <i class="bi bi-telephone-fill me-2"></i> Call: {{ \App\Models\Setting::get('contact_phone', '+91 7418191487') }}
            </a>
        </div>
    </div>
</section>
@endsection
