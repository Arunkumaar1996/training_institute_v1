<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | {{ \App\Models\Setting::get('institute_name', 'TechMaster Institute') }}</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --bs-font-sans-serif: 'Plus Jakarta Sans', system-ui, sans-serif;
            --admin-sidebar-width: 260px;
            --admin-sidebar-bg: #111827;
            --admin-sidebar-color: #9ca3af;
            --admin-sidebar-active: #3b82f6;
        }

        body {
            font-family: var(--bs-font-sans-serif);
            background-color: #f3f4f6;
            color: #1f2937;
            font-size: 0.925rem;
        }

        /* Sidebar Styles */
        #admin-sidebar {
            width: var(--admin-sidebar-width);
            background-color: var(--admin-sidebar-bg);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        #admin-content {
            margin-left: var(--admin-sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            color: #ffffff;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
        }

        .sidebar-section-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6b7280;
            padding: 1rem 1.5rem 0.4rem;
            font-weight: 700;
        }

        .sidebar-nav-item {
            color: var(--admin-sidebar-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-nav-item:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-nav-item.active {
            color: #ffffff;
            background-color: rgba(59, 130, 246, 0.15);
            border-left-color: var(--admin-sidebar-active);
            font-weight: 600;
        }

        .sidebar-nav-item i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
        }

        /* Top Header Navbar */
        .admin-topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        /* Responsive Breakpoints */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 1025;
            display: none;
            backdrop-filter: blur(2px);
            transition: opacity 0.3s ease;
        }
        .sidebar-backdrop.show {
            display: block;
        }

        @media (max-width: 991.98px) {
            #admin-sidebar {
                margin-left: calc(-1 * var(--admin-sidebar-width));
                box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25);
            }
            #admin-sidebar.show {
                margin-left: 0;
            }
            #admin-content {
                margin-left: 0;
            }
            .admin-topbar {
                padding: 0.5rem 1rem;
            }
            .kpi-card {
                margin-bottom: 0.75rem;
            }
        }

        .kpi-card {
            border-radius: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        .kpi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar Navigation for Desktop & Mobile Offcanvas -->
    <aside id="admin-sidebar" class="d-flex flex-column">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <div class="bg-primary text-white rounded-3 p-1 px-2">
                <i class="bi bi-motherboard fs-5"></i>
            </div>
            <div>
                <span class="d-block lh-1 fs-6">{{ \App\Models\Setting::get('institute_name', 'TechMaster') }}</span>
                <small class="text-xs text-muted" style="font-size: 0.7rem;">Management Portal</small>
            </div>
        </a>

        <div class="flex-grow-1 py-2">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <!-- Management Section -->
            <div class="sidebar-section-title">Academic Management</div>
            <a href="{{ route('admin.students.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.students*') ? 'active' : '' }}">
                <i class="bi bi-people-fill text-primary"></i> Students
            </a>
            <a href="{{ route('admin.admissions.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.admissions*') ? 'active' : '' }}">
                <i class="bi bi-person-check-fill text-success"></i> Admissions
            </a>
            <a href="{{ route('admin.courses.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.courses*') ? 'active' : '' }}">
                <i class="bi bi-journal-code text-warning"></i> Courses
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <i class="bi bi-grid-fill text-info"></i> Course Categories
            </a>
            <a href="{{ route('admin.batches.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.batches*') ? 'active' : '' }}">
                <i class="bi bi-calendar3-range text-danger"></i> Batches & Schedules
            </a>
            <a href="{{ route('admin.trainers.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.trainers*') ? 'active' : '' }}">
                <i class="bi bi-mortarboard-fill text-primary"></i> Trainers / Faculty
            </a>
            <a href="{{ route('admin.employees.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.employees*') ? 'active' : '' }}">
                <i class="bi bi-person-badge text-secondary"></i> Employees & Staff
            </a>
            <a href="{{ route('admin.departments.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.departments*') ? 'active' : '' }}">
                <i class="bi bi-diagram-2 text-muted"></i> Departments
            </a>

            <!-- Finance Section -->
            <div class="sidebar-section-title">Finance & Accounts</div>
            <a href="{{ route('admin.fees.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.fees.index') ? 'active' : '' }}">
                <i class="bi bi-cash-stack text-success"></i> Fees & Ledger
            </a>
            <a href="{{ route('admin.fees.installments') }}" class="sidebar-nav-item {{ request()->routeIs('admin.fees.installments') ? 'active' : '' }}">
                <i class="bi bi-calendar-event text-warning"></i> Fee Installments
            </a>
            <a href="{{ route('admin.fees.overdue') }}" class="sidebar-nav-item {{ request()->routeIs('admin.fees.overdue') ? 'active' : '' }}">
                <i class="bi bi-exclamation-octagon-fill text-danger"></i> Overdue Fees
            </a>
            <a href="{{ route('admin.payments.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
                <i class="bi bi-receipt-cutoff text-info"></i> Payments & Receipts
            </a>

            <!-- Attendance Section -->
            <div class="sidebar-section-title">Attendance Tracking</div>
            <a href="{{ route('admin.attendance.students') }}" class="sidebar-nav-item {{ request()->routeIs('admin.attendance.students') ? 'active' : '' }}">
                <i class="bi bi-check2-square text-success"></i> Student Batch Attendance
            </a>
            <a href="{{ route('admin.attendance.employees') }}" class="sidebar-nav-item {{ request()->routeIs('admin.attendance.employees') ? 'active' : '' }}">
                <i class="bi bi-person-check text-primary"></i> Staff Attendance
            </a>
            <a href="{{ route('admin.attendance.reports') }}" class="sidebar-nav-item {{ request()->routeIs('admin.attendance.reports') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line text-warning"></i> Attendance % Reports
            </a>

            <!-- Growth CRM Section -->
            <div class="sidebar-section-title">CRM & Growth</div>
            <a href="{{ route('admin.enquiries.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.enquiries*') ? 'active' : '' }}">
                <i class="bi bi-funnel-fill text-warning"></i> Enquiries & Leads
            </a>

            <!-- Certificates -->
            <div class="sidebar-section-title">Certificates</div>
            <a href="{{ route('admin.certificates.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.certificates*') ? 'active' : '' }}">
                <i class="bi bi-award-fill text-success"></i> Issue & Verify Certificates
            </a>

            <!-- Reports Section -->
            <div class="sidebar-section-title">Reports & Export</div>
            <a href="{{ route('admin.reports.fees') }}" class="sidebar-nav-item {{ request()->routeIs('admin.reports.fees') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-spreadsheet text-success"></i> Fee Collections Report
            </a>
            <a href="{{ route('admin.reports.admissions') }}" class="sidebar-nav-item {{ request()->routeIs('admin.reports.admissions') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-person text-primary"></i> Admissions Report
            </a>
            <a href="{{ route('admin.reports.leads') }}" class="sidebar-nav-item {{ request()->routeIs('admin.reports.leads') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow text-info"></i> Lead Conversion Report
            </a>

            <!-- Website CMS Section -->
            <div class="sidebar-section-title">Website CMS</div>
            <a href="{{ route('admin.cms.testimonials') }}" class="sidebar-nav-item {{ request()->routeIs('admin.cms.testimonials*') ? 'active' : '' }}">
                <i class="bi bi-star-fill text-warning"></i> Reviews & Testimonials
            </a>
            <a href="{{ route('admin.cms.gallery') }}" class="sidebar-nav-item {{ request()->routeIs('admin.cms.gallery*') ? 'active' : '' }}">
                <i class="bi bi-images text-info"></i> Photo Gallery
            </a>
            <a href="{{ route('admin.cms.faqs') }}" class="sidebar-nav-item {{ request()->routeIs('admin.cms.faqs*') ? 'active' : '' }}">
                <i class="bi bi-question-circle text-primary"></i> FAQs
            </a>
            <a href="{{ route('admin.cms.blogs') }}" class="sidebar-nav-item {{ request()->routeIs('admin.cms.blogs*') ? 'active' : '' }}">
                <i class="bi bi-newspaper text-danger"></i> Blog Articles
            </a>
            <a href="{{ route('admin.cms.contact-messages') }}" class="sidebar-nav-item {{ request()->routeIs('admin.cms.contact-messages*') ? 'active' : '' }}">
                <i class="bi bi-envelope-paper text-success"></i> Contact Messages
            </a>

            <!-- System Settings & Security -->
            <div class="sidebar-section-title">System & Security</div>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill text-secondary"></i> Master Settings
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="bi bi-person-lock text-primary"></i> Users & Staff Logins
            </a>
            <a href="{{ route('admin.roles.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                <i class="bi bi-shield-shaded text-warning"></i> Roles & RBAC
            </a>
            <a href="{{ route('admin.audit-logs.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.audit-logs*') ? 'active' : '' }}">
                <i class="bi bi-shield-check text-success"></i> Security Audit Logs
            </a>
        </div>
    </aside>

    <!-- Main Content Container -->
    <div id="admin-content">
        <!-- Top Navbar -->
        <header class="admin-topbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary btn-sm d-lg-none" type="button" id="sidebarToggleBtn" aria-label="Toggle Sidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill d-none d-md-inline-flex align-items-center gap-1">
                    <i class="bi bi-globe"></i> View Public Website
                </a>
            </div>

            <!-- Quick Add Actions Dropdown -->
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-sm btn-primary dropdown-toggle rounded-pill px-3 fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-plus-circle me-1"></i> Quick Action
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 py-2">
                        <li><a class="dropdown-item py-2" href="{{ route('admin.students.create') }}"><i class="bi bi-person-plus text-primary me-2"></i> Add New Student</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.admissions.create') }}"><i class="bi bi-file-earmark-plus text-success me-2"></i> New Admission</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.payments.create') }}"><i class="bi bi-credit-card text-info me-2"></i> Record Payment</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.enquiries.create') }}"><i class="bi bi-chat-left-dots text-warning me-2"></i> Add Lead / Enquiry</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.courses.create') }}"><i class="bi bi-journal-plus text-danger me-2"></i> Add Course</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.batches.create') }}"><i class="bi bi-calendar-plus text-secondary me-2"></i> Create Batch</a></li>
                    </ul>
                </div>

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light border d-flex align-items-center gap-2 rounded-pill py-1 px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-5 text-primary"></i>
                        <div class="text-start d-none d-md-block lh-1">
                            <strong class="small d-block">{{ auth()->user()->name }}</strong>
                            <span class="badge bg-primary-subtle text-primary text-xs" style="font-size: 0.65rem;">{{ auth()->user()->role_name }}</span>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 py-2">
                        <li class="px-3 py-1 border-bottom small text-muted">
                            Signed in as <strong>{{ auth()->user()->email }}</strong>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear me-2 text-muted"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <main class="flex-grow-1 p-3 p-md-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Admin Footer -->
        <footer class="bg-white border-top py-3 px-4 text-center small text-muted">
            &copy; {{ date('Y') }} {{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }} • High Security Management System
        </footer>
    </div>

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="sidebar-backdrop"></div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery 3.7 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            // CSRF Setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Mobile sidebar toggle & backdrop handlers
            function toggleSidebar() {
                $('#admin-sidebar').toggleClass('show');
                $('#sidebarBackdrop').toggleClass('show');
            }

            $('#sidebarToggleBtn, #sidebarBackdrop').on('click', function() {
                toggleSidebar();
            });

            // Close on escape key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && $('#admin-sidebar').hasClass('show')) {
                    toggleSidebar();
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
