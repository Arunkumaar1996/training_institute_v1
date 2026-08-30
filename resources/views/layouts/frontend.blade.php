<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Advanced Mobile & Laptop Repair Training Institute') | {{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }}</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Premier training institute for mobile repairing, laptop hardware and software, and chip level IC engineering. Basic to advanced practical courses with job placement.')">
    <meta name="keywords" content="@yield('meta_keywords', 'mobile repair course, laptop chip level training, smartphone technician course, basic to advanced electronics, hardware training')">
    <meta property="og:title" content="@yield('title', 'Advanced Mobile & Laptop Training Institute')">
    <meta property="og:description" content="@yield('meta_description', 'Empowering technical careers through chip-level mobile and laptop repairing courses with 100% practical lab training.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ \App\Models\Setting::get('institute_favicon', '/assets/favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-font-sans-serif: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-scale: 1;
            --brand-primary: #0d6efd;
            --brand-gradient: linear-gradient(135deg, #0d6efd 0%, #0045a5 100%);
            --brand-secondary: #ff8c00;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html {
            overflow-x: hidden !important;
            max-width: 100% !important;
            width: 100% !important;
        }

        body {
            font-size: calc(1rem * var(--font-scale));
            font-family: var(--bs-font-sans-serif);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #212529;
            background-color: #f8fafc;
            overflow-x: hidden !important;
            max-width: 100% !important;
            width: 100% !important;
            position: relative;
        }

        main { 
            flex: 1; 
            overflow-x: hidden;
            width: 100%;
            max-width: 100%;
        }

        img, svg, video, canvas {
            max-width: 100%;
            height: auto;
        }

        h1, h2, h3, h4, h5, h6, p, span, a, label {
            overflow-wrap: break-word;
            word-break: normal;
        }

        /* GIGW 3.0 High Contrast Theme */
        body.high-contrast-mode {
            background-color: #000000 !important;
            color: #ffff00 !important;
        }
        body.high-contrast-mode .card,
        body.high-contrast-mode .navbar,
        body.high-contrast-mode .dropdown-menu,
        body.high-contrast-mode .modal-content,
        body.high-contrast-mode footer,
        body.high-contrast-mode .bg-light,
        body.high-contrast-mode .bg-white {
            background-color: #000000 !important;
            color: #ffff00 !important;
            border-color: #ffff00 !important;
        }
        body.high-contrast-mode a,
        body.high-contrast-mode h1,
        body.high-contrast-mode h2,
        body.high-contrast-mode h3,
        body.high-contrast-mode h4,
        body.high-contrast-mode h5,
        body.high-contrast-mode h6,
        body.high-contrast-mode .text-muted,
        body.high-contrast-mode .text-primary,
        body.high-contrast-mode .text-dark {
            color: #ffff00 !important;
        }
        body.high-contrast-mode .btn-primary,
        body.high-contrast-mode .btn-success,
        body.high-contrast-mode .btn-danger,
        body.high-contrast-mode .btn-warning {
            background-color: #ffff00 !important;
            color: #000000 !important;
            border-color: #ffff00 !important;
            font-weight: 700 !important;
        }

        /* Focus indicators for keyboard accessibility */
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 3px solid #ff8c00 !important;
            outline-offset: 2px !important;
        }

        .hero-banner {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.95) 0%, rgba(2, 44, 107, 0.95) 100%), url('https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
        }

        .badge-chip {
            font-size: 0.75rem;
            padding: 0.35em 0.7em;
            border-radius: 50rem;
        }

        .course-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }
        .course-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .floating-action-buttons {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .float-btn {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            transition: transform 0.2s;
            font-size: 1.4rem;
            color: #fff;
            text-decoration: none;
        }
        .float-btn:hover { transform: scale(1.1); color: #fff; }
        .float-whatsapp { background-color: #25d366; }
        .float-call { background-color: #0d6efd; }

        /* Navbar & Header Responsive Layout Fixes */
        .navbar-brand {
            white-space: nowrap !important;
        }
        .navbar-nav .nav-link {
            white-space: nowrap !important;
            padding-left: 0.6rem !important;
            padding-right: 0.6rem !important;
            font-size: 0.95rem;
        }
        .navbar-nav .nav-link.active {
            color: var(--bs-primary) !important;
            font-weight: 700 !important;
        }
        .navbar .btn {
            white-space: nowrap !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Mobile-First Responsiveness Enhancements */
        @media (max-width: 767.98px) {
            body {
                padding-bottom: 70px !important;
            }
            .floating-action-buttons {
                bottom: 80px !important;
                right: 16px !important;
            }
            .float-btn {
                width: 44px;
                height: 44px;
                font-size: 1.2rem;
            }
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .display-4, .display-5 {
                font-size: clamp(1.85rem, 5.5vw, 2.75rem) !important;
            }
            .btn {
                min-height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        }
        .mobile-bottom-bar {
            z-index: 1035;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- GIGW 3.0 Accessibility Controls Bar -->
    @include('components.accessibility-bar')

    <!-- Top Contact Bar -->
    <div class="bg-primary text-white py-1 d-none d-xl-block border-bottom border-primary-subtle overflow-hidden">
        <div class="container-fluid px-3 px-xl-4 px-xxl-5 d-flex justify-content-between align-items-center small text-nowrap">
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-telephone-fill me-1 text-warning"></i> Helpline: <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+91 7418191487') }}" class="text-white text-decoration-none fw-semibold">{{ \App\Models\Setting::get('contact_phone', '+91 7418191487') }}</a></span>
                <span><i class="bi bi-envelope-fill me-1 text-warning"></i> <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'aruntech1996@gmail.com') }}" class="text-white text-decoration-none">{{ \App\Models\Setting::get('contact_email', 'aruntech1996@gmail.com') }}</a></span>
                <span><i class="bi bi-clock-fill me-1 text-warning"></i> {{ \App\Models\Setting::get('working_hours', 'Mon - Sat: 9:00 AM - 7:00 PM') }}</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('certificate.verify') }}" class="text-white text-decoration-none badge bg-warning text-dark px-2 py-1">
                    <i class="bi bi-patch-check-fill"></i> Verify Certificate
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none fw-semibold">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-white text-decoration-none">
                        <i class="bi bi-person-circle"></i> Staff / Student Login
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky-top shadow-sm bg-white border-bottom">
        <nav class="navbar navbar-expand-xl py-2" aria-label="Main Navigation">
            <div class="container-fluid px-3 px-xl-4 px-xxl-5">
                <a class="navbar-brand d-flex align-items-center gap-2 me-2 me-xl-3" href="{{ route('home') }}">
                    <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                        <i class="bi bi-motherboard fs-4"></i>
                    </div>
                    <div class="d-inline-block">
                        <span class="fw-bold fs-5 text-primary d-block lh-1 text-nowrap">{{ \App\Models\Setting::get('institute_name', 'TechMaster Institute') }}</span>
                        <small class="text-muted text-xs d-block text-nowrap" style="font-size: 0.75rem;">Mobile & Laptop Chip Level Training</small>
                    </div>
                </a>

                <!-- Mobile Toggler -->
                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Desktop Menu -->
                <div class="collapse navbar-collapse" id="desktopNav">
                    <ul class="navbar-nav ms-auto mb-2 mb-xl-0 align-items-xl-center fw-medium gap-1">
                        <li class="nav-item"><a class="nav-link text-nowrap {{ request()->routeIs('home') ? 'active text-primary fw-bold' : '' }}" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-nowrap {{ request()->routeIs('about') ? 'active text-primary fw-bold' : '' }}" href="{{ route('about') }}">About Us</a></li>
                        
                        <!-- Courses Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-nowrap {{ request()->routeIs('courses*') ? 'active text-primary fw-bold' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Courses
                            </a>
                            <ul class="dropdown-menu shadow-lg border-0 rounded-3 py-2">
                                <li><a class="dropdown-item py-2 fw-semibold" href="{{ route('courses') }}"><i class="bi bi-grid-fill text-primary me-2"></i> All Courses</a></li>
                                <li><hr class="dropdown-divider"></li>
                                @foreach(\App\Models\CourseCategory::where('status', true)->take(6)->get() as $navCat)
                                    <li><a class="dropdown-item py-2" href="{{ route('courses', ['category' => $navCat->slug]) }}"><i class="bi bi-chevron-right text-muted small me-2"></i> {{ $navCat->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link text-nowrap {{ request()->routeIs('trainers*') ? 'active text-primary fw-bold' : '' }}" href="{{ route('trainers') }}">Trainers</a></li>
                        <li class="nav-item"><a class="nav-link text-nowrap {{ request()->routeIs('gallery') ? 'active text-primary fw-bold' : '' }}" href="{{ route('gallery') }}">Lab & Gallery</a></li>

                        <!-- More Dropdown for Secondary Links -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-nowrap {{ request()->routeIs(['testimonials', 'blog*', 'faq']) ? 'active text-primary fw-bold' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                More
                            </a>
                            <ul class="dropdown-menu shadow-lg border-0 rounded-3 py-2">
                                <li><a class="dropdown-item py-2" href="{{ route('testimonials') }}"><i class="bi bi-star-fill text-warning me-2"></i> Student Reviews</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('blog') }}"><i class="bi bi-newspaper text-info me-2"></i> Blog & Tech Guides</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('faq') }}"><i class="bi bi-question-circle text-primary me-2"></i> FAQs</a></li>
                                <li><a class="dropdown-item py-2" href="{{ route('certificate.verify') }}"><i class="bi bi-patch-check text-success me-2"></i> Verify Certificate</a></li>
                            </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link text-nowrap {{ request()->routeIs('contact') ? 'active text-primary fw-bold' : '' }}" href="{{ route('contact') }}">Contact</a></li>
                    </ul>

                    <div class="d-flex align-items-center gap-2 ms-xl-3 text-nowrap flex-shrink-0">
                        <button type="button" class="btn btn-outline-primary btn-sm px-2 px-xxl-3 py-2 rounded-pill text-nowrap d-none d-xxl-inline-flex" data-bs-toggle="modal" data-bs-target="#enquiryModal">
                            <i class="bi bi-chat-dots-fill me-1"></i> Quick Enquiry
                        </button>
                        <a href="{{ route('admission') }}" class="btn btn-warning btn-sm px-3 py-2 rounded-pill fw-bold text-dark shadow-sm text-nowrap">
                            <i class="bi bi-person-plus-fill me-1"></i> Apply Online
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Offcanvas Mobile Navigation Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold text-primary" id="mobileMenuLabel">
                <i class="bi bi-motherboard me-1"></i> Menu
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between p-3">
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item"><a class="nav-link text-dark" href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="{{ route('about') }}"><i class="bi bi-info-circle me-2"></i> About Us</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="{{ route('courses') }}"><i class="bi bi-journal-code me-2"></i> All Courses</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="{{ route('trainers') }}"><i class="bi bi-people me-2"></i> Trainers</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="{{ route('testimonials') }}"><i class="bi bi-star me-2"></i> Student Reviews</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="{{ route('gallery') }}"><i class="bi bi-images me-2"></i> Gallery & Practical Labs</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="{{ route('blog') }}"><i class="bi bi-newspaper me-2"></i> Blog & Tech News</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="{{ route('faq') }}"><i class="bi bi-question-circle me-2"></i> FAQs</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="{{ route('contact') }}"><i class="bi bi-telephone me-2"></i> Contact Us</a></li>
                <li class="nav-item"><a class="nav-link text-warning fw-bold" href="{{ route('certificate.verify') }}"><i class="bi bi-patch-check me-2"></i> Verify Certificate</a></li>
            </ul>

            <div class="mt-4 pt-3 border-top d-grid gap-2">
                <a href="{{ route('admission') }}" class="btn btn-warning fw-bold text-dark py-2">
                    <i class="bi bi-person-plus-fill me-1"></i> Apply for Admission
                </a>
                <button type="button" class="btn btn-primary py-2" data-bs-toggle="modal" data-bs-target="#enquiryModal">
                    <i class="bi bi-chat-dots-fill me-1"></i> Request Callback
                </button>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark py-2">
                        <i class="bi bi-speedometer2 me-1"></i> Admin Portal
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark py-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login Portal
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Content Area with Landmark ID -->
    <main id="main-content" role="main" tabindex="-1">
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Floating Quick Action Buttons -->
    <div class="floating-action-buttons d-none d-md-flex" aria-label="Quick Communication">
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact_whatsapp', '917418191487')) }}?text=Hello%2C%20I%20am%20interested%20in%20mobile%20and%20laptop%20courses" target="_blank" rel="noopener noreferrer" class="float-btn float-whatsapp" title="Chat on WhatsApp" aria-label="Direct WhatsApp Chat">
            <i class="bi bi-whatsapp"></i>
        </a>
        <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+917418191487') }}" class="float-btn float-call" title="Call Us Now" aria-label="Call Helpline">
            <i class="bi bi-telephone-fill"></i>
        </a>
    </div>

    <!-- Mobile Sticky Bottom Quick Action Bar (Visible on mobile screens <= 768px) -->
    <div class="mobile-bottom-bar d-md-none bg-white border-top shadow-lg py-2 px-3 fixed-bottom d-flex justify-content-between align-items-center" role="navigation" aria-label="Mobile Quick Actions">
        <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+917418191487') }}" class="mobile-bottom-item text-center text-decoration-none text-dark flex-fill py-1">
            <i class="bi bi-telephone-fill fs-5 text-primary d-block"></i>
            <span class="fw-semibold" style="font-size: 0.72rem;">Call</span>
        </a>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact_whatsapp', '917418191487')) }}?text=Hello%2C%20I%20am%20interested%20in%20courses" target="_blank" rel="noopener noreferrer" class="mobile-bottom-item text-center text-decoration-none text-dark flex-fill py-1">
            <i class="bi bi-whatsapp fs-5 text-success d-block"></i>
            <span class="fw-semibold" style="font-size: 0.72rem;">WhatsApp</span>
        </a>
        <button type="button" class="mobile-bottom-item text-center text-decoration-none text-dark flex-fill border-0 bg-transparent py-1" data-bs-toggle="modal" data-bs-target="#enquiryModal">
            <i class="bi bi-chat-dots-fill fs-5 text-warning d-block"></i>
            <span class="fw-semibold" style="font-size: 0.72rem;">Enquiry</span>
        </button>
        <a href="{{ route('admission') }}" class="btn btn-warning btn-sm rounded-pill fw-bold text-dark px-3 ms-2 shadow-sm d-flex align-items-center gap-1">
            <i class="bi bi-person-plus-fill"></i> Apply
        </a>
    </div>

    <!-- Quick Enquiry Modal -->
    <div class="modal fade" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="enquiryModalLabel">
                        <i class="bi bi-envelope-check me-2"></i> Free Course Counselling & Enquiry
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="quickEnquiryForm" action="{{ route('enquiry.submit') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div id="enquiryAlert" class="d-none alert alert-dismissible" role="alert"></div>

                        <div class="mb-3">
                            <label for="enq_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-3" id="enq_name" name="name" required placeholder="Enter your full name">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="enq_mobile" class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control rounded-3" id="enq_mobile" name="mobile" required placeholder="10-digit mobile number">
                            </div>
                            <div class="col-md-6">
                                <label for="enq_email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" class="form-control rounded-3" id="enq_email" name="email" placeholder="name@example.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="enq_course" class="form-label fw-semibold">Select Course Interested</label>
                            <select class="form-select rounded-3" id="enq_course" name="course_id">
                                <option value="">-- Choose Course --</option>
                                @foreach(\App\Models\Course::where('status', 'active')->orderBy('course_name')->get() as $courseOpt)
                                    <option value="{{ $courseOpt->id }}">{{ $courseOpt->course_name }} ({{ $courseOpt->level }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="enq_message" class="form-label fw-semibold">Your Message / Query</label>
                            <textarea class="form-control rounded-3" id="enq_message" name="message" rows="3" placeholder="Tell us your current qualification or questions..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3">
                        <button type="button" class="btn btn-secondary px-3 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="btnSubmitEnquiry" class="btn btn-primary px-4 rounded-pill fw-bold">
                            <span class="spinner-border spinner-border-sm d-none me-1" id="enquirySpinner" role="status" aria-hidden="true"></span>
                            Submit Enquiry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- GIGW 3.0 Standard Accessible Footer -->
    <footer class="bg-dark text-white pt-5 pb-3 border-top border-secondary mt-5 overflow-hidden" role="contentinfo">
        <div class="container">
            <div class="row g-4 pb-4">
                <!-- Institute Intro -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-primary text-white rounded-3 p-2">
                            <i class="bi bi-motherboard fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-white mb-0">{{ \App\Models\Setting::get('institute_name', 'TechMaster Institute') }}</h5>
                    </div>
                    <p class="text-white-50 small mb-3">
                        India's premier training center for Mobile Hardware, Software, Chip-Level IC Repairing, and Laptop Engineering from Basic to Advanced Master levels.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ \App\Models\Setting::get('social_facebook', '#') }}" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px;height:36px;" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px;height:36px;" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_youtube', '#') }}" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px;height:36px;" title="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="{{ \App\Models\Setting::get('social_twitter', '#') }}" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px;height:36px;" title="Twitter"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h6 class="fw-bold text-warning text-uppercase mb-3">Quick Links</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right text-primary me-1"></i> Home</a></li>
                        <li><a href="{{ route('about') }}" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right text-primary me-1"></i> About Us</a></li>
                        <li><a href="{{ route('courses') }}" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right text-primary me-1"></i> All Courses</a></li>
                        <li><a href="{{ route('admission') }}" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right text-primary me-1"></i> Online Admission</a></li>
                        <li><a href="{{ route('certificate.verify') }}" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right text-primary me-1"></i> Certificate Verification</a></li>
                        <li><a href="{{ route('contact') }}" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-chevron-right text-primary me-1"></i> Contact Us</a></li>
                    </ul>
                </div>

                <!-- Popular Courses -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-warning text-uppercase mb-3">Popular Courses</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        @foreach(\App\Models\Course::where('status', 'active')->where('featured', true)->take(5)->get() as $ftCourse)
                            <li><a href="{{ route('course.details', $ftCourse->slug) }}" class="text-white-50 text-decoration-none hover-white"><i class="bi bi-cpu-fill text-warning me-1"></i> {{ $ftCourse->course_name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact & Address -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-warning text-uppercase mb-3">Contact Information</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 text-white-50 mb-0">
                        <li><i class="bi bi-geo-alt-fill text-primary me-2"></i> {{ \App\Models\Setting::get('contact_address', 'alwarthirunagar, valasaravakkam, chennai-600 087.') }}</li>
                        <li><i class="bi bi-telephone-fill text-primary me-2"></i> {{ \App\Models\Setting::get('contact_phone', '+91 7418191487') }}</li>
                        <li><i class="bi bi-envelope-fill text-primary me-2"></i> {{ \App\Models\Setting::get('contact_email', 'aruntech1996@gmail.com') }}</li>
                        <li><i class="bi bi-clock-fill text-primary me-2"></i> {{ \App\Models\Setting::get('working_hours', 'Mon - Sat: 9:00 AM - 7:00 PM') }}</li>
                    </ul>
                </div>
            </div>

            <!-- GIGW 3.0 Mandatory Compliance Links Bar -->
            <div class="border-top border-secondary pt-3 pb-2 overflow-hidden">
                <div class="d-flex flex-wrap justify-content-center gap-2 gap-sm-3 text-xs text-white-50 small mb-2">
                    <a href="{{ route('page.show', 'accessibility') }}" class="text-white-50 text-decoration-none">Accessibility Statement</a>
                    <span class="d-none d-sm-inline">|</span>
                    <a href="{{ route('page.show', 'citizen-charter') }}" class="text-white-50 text-decoration-none">Citizen Charter</a>
                    <span class="d-none d-sm-inline">|</span>
                    <a href="{{ route('page.show', 'privacy') }}" class="text-white-50 text-decoration-none">Privacy Policy</a>
                    <span class="d-none d-sm-inline">|</span>
                    <a href="{{ route('page.show', 'terms') }}" class="text-white-50 text-decoration-none">Terms & Conditions</a>
                    <span class="d-none d-sm-inline">|</span>
                    <a href="{{ route('page.show', 'disclaimer') }}" class="text-white-50 text-decoration-none">Disclaimer</a>
                    <span class="d-none d-sm-inline">|</span>
                    <a href="{{ route('page.show', 'hyperlinking-policy') }}" class="text-white-50 text-decoration-none">Hyperlinking Policy</a>
                    <span class="d-none d-sm-inline">|</span>
                    <a href="{{ route('page.show', 'copyright') }}" class="text-white-50 text-decoration-none">Copyright Policy</a>
                    <span class="d-none d-sm-inline">|</span>
                    <a href="{{ route('page.show', 'sitemap') }}" class="text-white-50 text-decoration-none">Website Sitemap</a>
                </div>
            </div>

            <!-- Development & Demonstration Purpose Notice -->
            <div class="alert alert-warning border-0 bg-warning-subtle text-dark text-center small rounded-3 py-2 px-3 my-3 shadow-sm" role="note" aria-label="Development Notice">
                <i class="bi bi-cone-striped text-warning-emphasis me-2 fs-6"></i>
                <strong>Development & Testing Notice:</strong> This website is created for demonstration, development, and testing purposes. All mock courses, demo student records, and sample certificates displayed are for evaluation preview.
            </div>

            <!-- Bottom Copyright & Last Updated Indicator -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-white-50 pt-2 border-top border-secondary">
                <p class="mb-0">&copy; {{ date('Y') }} {{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }}. All rights reserved.</p>
                <div class="d-flex align-items-center gap-3">
                    <span>Last Updated: <strong class="text-light">{{ date('d M Y') }}</strong></span>
                    <span>Visitors: <strong class="text-warning">24,580</strong></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery 3.7 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- GIGW 3.0 & AJAX Handlers Script -->
    <script>
        $(document).ready(function() {
            // CSRF Setup for jQuery AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // GIGW 3.0 Text Scaling Handlers
            let currentScale = parseFloat(localStorage.getItem('gigw_font_scale')) || 1;
            function applyFontScale(scale) {
                document.documentElement.style.setProperty('--font-scale', scale);
                localStorage.setItem('gigw_font_scale', scale);
            }
            applyFontScale(currentScale);

            $('#font-increase').on('click', function() {
                if (currentScale < 1.3) {
                    currentScale += 0.1;
                    applyFontScale(currentScale);
                }
            });
            $('#font-decrease').on('click', function() {
                if (currentScale > 0.8) {
                    currentScale -= 0.1;
                    applyFontScale(currentScale);
                }
            });
            $('#font-reset').on('click', function() {
                currentScale = 1;
                applyFontScale(currentScale);
            });

            // Theme Contrast Handlers
            const savedTheme = localStorage.getItem('gigw_theme') || 'light';
            function applyTheme(theme) {
                if (theme === 'high-contrast') {
                    $('body').addClass('high-contrast-mode');
                    $('html').attr('data-bs-theme', 'dark');
                } else if (theme === 'dark') {
                    $('body').removeClass('high-contrast-mode');
                    $('html').attr('data-bs-theme', 'dark');
                } else {
                    $('body').removeClass('high-contrast-mode');
                    $('html').attr('data-bs-theme', 'light');
                }
                localStorage.setItem('gigw_theme', theme);
            }
            applyTheme(savedTheme);

            $('#theme-default').on('click', () => applyTheme('light'));
            $('#theme-dark').on('click', () => applyTheme('dark'));
            $('#theme-high-contrast').on('click', () => applyTheme('high-contrast'));

            // AJAX Quick Enquiry Form Submission
            $('#ajaxEnquiryForm').on('submit', function(e) {
                e.preventDefault();
                const $form = $(this);
                const $btn = $('#btnSubmitEnquiry');
                const $spinner = $('#enquirySpinner');
                const $alert = $('#enquiryAlert');

                $btn.prop('disabled', true);
                $spinner.removeClass('d-none');
                $alert.addClass('d-none').removeClass('alert-success alert-danger');

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        $alert.removeClass('d-none').addClass('alert-success')
                            .html('<i class="bi bi-check-circle-fill me-2"></i> ' + response.message);
                        $form[0].reset();
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('enquiryModal'));
                            if (modal) modal.hide();
                            $alert.addClass('d-none');
                        }, 3000);
                    },
                    error: function(xhr) {
                        let errorMsg = 'An error occurred. Please check the fields and try again.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        $alert.removeClass('d-none').addClass('alert-danger')
                            .html('<i class="bi bi-exclamation-triangle-fill me-2"></i> ' + errorMsg);
                    },
                    complete: function() {
                        $btn.prop('disabled', false);
                        $spinner.addClass('d-none');
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
