@extends('layouts.admin')

@section('title', 'Institute Growth & Analytics Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Business & Institute Dashboard</h3>
        <p class="text-muted small mb-0">Live financial, admission, and attendance metrics for {{ date('l, d F Y') }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.admissions.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-person-plus-fill me-1"></i> New Admission
        </a>
        <a href="{{ route('admin.payments.create') }}" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
            <i class="bi bi-credit-card me-1"></i> Collect Fee
        </a>
    </div>
</div>

<!-- High Level KPI Summary Cards Row -->
<div class="row g-3 mb-4">
    <!-- Active Students -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white kpi-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Total Students</span>
                    <h3 class="fw-bold text-primary my-1">{{ $totalStudents }}</h3>
                    <small class="text-success"><i class="bi bi-check-circle me-1"></i> {{ $activeStudents }} Active</small>
                </div>
                <div class="bg-primary-subtle text-primary rounded-circle p-3 fs-3">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Collection -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white kpi-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Today's Collection</span>
                    <h3 class="fw-bold text-success my-1">₹{{ number_format($todayCollection) }}</h3>
                    <small class="text-muted">Month: ₹{{ number_format($monthCollection) }}</small>
                </div>
                <div class="bg-success-subtle text-success rounded-circle p-3 fs-3">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pending Fees -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white kpi-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Pending Fees</span>
                    <h3 class="fw-bold text-danger my-1">₹{{ number_format($totalPendingFees) }}</h3>
                    <small class="text-danger"><a href="{{ route('admin.fees.overdue') }}" class="text-danger text-decoration-none">View Overdue</a></small>
                </div>
                <div class="bg-danger-subtle text-danger rounded-circle p-3 fs-3">
                    <i class="bi bi-exclamation-octagon-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Enquiries & Conversion -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white kpi-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small text-uppercase fw-semibold">Leads & Enquiries</span>
                    <h3 class="fw-bold text-warning my-1">{{ $totalEnquiries }}</h3>
                    <small class="text-info"><i class="bi bi-graph-up-arrow me-1"></i> {{ $conversionRate }}% Conversion</small>
                </div>
                <div class="bg-warning-subtle text-warning rounded-circle p-3 fs-3">
                    <i class="bi bi-funnel-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-info-subtle text-info rounded-3 p-3 fs-4"><i class="bi bi-calendar-check-fill"></i></div>
                <div>
                    <span class="text-muted small">Active Batches</span>
                    <h5 class="fw-bold mb-0">{{ $activeBatches }} Batches Running</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success-subtle text-success rounded-3 p-3 fs-4"><i class="bi bi-person-check-fill"></i></div>
                <div>
                    <span class="text-muted small">Today's Student Attendance</span>
                    <h5 class="fw-bold mb-0">{{ $todayStudentPresent }} / {{ $todayStudentTotal }} Marked Present</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary-subtle text-primary rounded-3 p-3 fs-4"><i class="bi bi-mortarboard-fill"></i></div>
                <div>
                    <span class="text-muted small">Faculty & Staff</span>
                    <h5 class="fw-bold mb-0">{{ $totalTrainers }} Trainers • {{ $totalEmployees }} Staff</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Visual Charts Row 1: Revenue & Admissions Growth -->
<div class="row g-4 mb-4">
    <!-- Revenue Growth Bar Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-bar-chart-fill text-primary me-2"></i> Monthly Revenue Collections</h5>
                    <small class="text-muted">Past 6 months fee collection trends (₹)</small>
                </div>
                <span class="badge bg-light text-muted border">Last 6 Months</span>
            </div>
            <div style="position: relative; height: 280px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Admissions Line Chart -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <h5 class="fw-bold text-dark mb-1"><i class="bi bi-person-plus-fill text-success me-2"></i> Admissions Trend</h5>
            <small class="text-muted d-block mb-3">Student enrollment trajectory</small>
            <div style="position: relative; height: 280px;">
                <canvas id="admissionsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Visual Charts Row 2: Pie & Doughnut Analytics -->
<div class="row g-4 mb-4">
    <!-- Pie Chart 1: Course Enrollment Share -->
    <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-pie-chart-fill text-primary me-2"></i> Course Enrollment</h5>
                <span class="badge bg-primary-subtle text-primary">By Program</span>
            </div>
            <div style="position: relative; height: 240px;">
                <canvas id="coursePieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Pie Chart 2: Lead Status Pipeline -->
    <div class="col-lg-4 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-funnel-fill text-warning me-2"></i> Lead Pipeline</h5>
                <span class="badge bg-warning-subtle text-warning">Enquiries</span>
            </div>
            <div style="position: relative; height: 240px;">
                <canvas id="leadStatusPieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Pie Chart 3: Payment Mode Distribution -->
    <div class="col-lg-4 col-md-12">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-wallet2 text-success me-2"></i> Payment Modes</h5>
                <span class="badge bg-success-subtle text-success">Collections</span>
            </div>
            <div style="position: relative; height: 240px;">
                <canvas id="paymentModeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Operational Tables & Shortcuts Row -->
<div class="row g-4 mb-4">
    <!-- Recent Student Admissions Table -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-mortarboard-fill text-primary me-2"></i> Recent Student Enrollments</h5>
                    <small class="text-muted">Latest admissions across all technical programs</small>
                </div>
                <a href="{{ route('admin.admissions.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">View All Admissions</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="table-light">
                        <tr>
                            <th>Student</th>
                            <th>Course & Batch</th>
                            <th>Fee Status</th>
                            <th>Balance</th>
                            <th>Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAdmissions as $adm)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $adm->student?->photo_url ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=100&q=80' }}" class="rounded-circle object-fit-cover" style="width: 32px; height: 32px;" alt="">
                                        <div>
                                            <strong class="text-dark d-block">{{ $adm->student?->full_name }}</strong>
                                            <span class="text-muted text-xs">{{ $adm->student?->student_code }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong class="d-block text-dark">{{ $adm->course?->course_name }}</strong>
                                    <small class="text-muted">{{ $adm->batch?->batch_name ?? 'Unassigned' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $adm->payment_status === 'Paid' ? 'success' : ($adm->payment_status === 'Partially Paid' ? 'warning' : 'danger') }} badge-chip">
                                        {{ $adm->payment_status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold {{ $adm->balance > 0 ? 'text-danger' : 'text-success' }}">₹{{ number_format($adm->balance) }}</span>
                                </td>
                                <td>{{ $adm->admission_date ? \Carbon\Carbon::parse($adm->admission_date)->format('d M Y') : '-' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.admissions.show', $adm->id) }}" class="btn btn-sm btn-light border rounded-pill px-2 py-1" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No recent admissions recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active & Upcoming Batches List -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-calendar3 text-info me-2"></i> Active Batches</h5>
                <a href="{{ route('admin.batches.index') }}" class="btn btn-sm btn-outline-info rounded-pill px-3">All Batches</a>
            </div>

            <div class="d-flex flex-column gap-3">
                @forelse($upcomingBatches as $ub)
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <strong class="text-dark">{{ $ub->batch_name }}</strong>
                            <span class="badge bg-{{ $ub->status === 'Active' ? 'success' : 'primary' }}">{{ $ub->status }}</span>
                        </div>
                        <small class="text-muted d-block mb-2">{{ $ub->course?->course_name }} • {{ $ub->days_schedule }} ({{ $ub->time_slot }})</small>
                        <div class="d-flex justify-content-between align-items-center small">
                            <span class="text-muted"><i class="bi bi-person-badge me-1"></i> {{ $ub->trainer?->name ?? 'Faculty Assigned' }}</span>
                            <span class="fw-semibold text-primary"><i class="bi bi-calendar-event me-1"></i> Starts: {{ $ub->start_date ? \Carbon\Carbon::parse($ub->start_date)->format('d M') : 'TBA' }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No active batches scheduled.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Leads Follow-ups & Recent Activities Row -->
<div class="row g-4">
    <!-- Follow-ups Pipeline -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history text-warning me-2"></i> Today's Follow-up Pipeline</h5>
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">All Leads</a>
            </div>

            @if($todayFollowUps->isNotEmpty() || $overdueFollowUps->isNotEmpty())
                <div class="d-flex flex-column gap-2">
                    @foreach($todayFollowUps as $tf)
                        <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center border-start border-warning border-4">
                            <div>
                                <strong class="text-dark d-block">{{ $tf->name }}</strong>
                                <small class="text-muted"><i class="bi bi-telephone me-1"></i> {{ $tf->mobile }} • {{ $tf->course?->course_name ?? 'General' }}</small>
                            </div>
                            <a href="{{ route('admin.enquiries.show', $tf->id) }}" class="btn btn-sm btn-warning rounded-pill px-3 fw-semibold">Action</a>
                        </div>
                    @endforeach

                    @foreach($overdueFollowUps as $of)
                        <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center border-start border-danger border-4">
                            <div>
                                <strong class="text-danger d-block">{{ $of->name }} (Overdue)</strong>
                                <small class="text-muted"><i class="bi bi-telephone me-1"></i> {{ $of->mobile }}</small>
                            </div>
                            <a href="{{ route('admin.enquiries.show', $of->id) }}" class="btn btn-sm btn-danger rounded-pill px-3 fw-semibold">Follow Up</a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-4 bg-light rounded-3 text-center text-muted">
                    <i class="bi bi-check2-all fs-2 d-block mb-1 text-success"></i>
                    All follow-ups are up to date for today!
                </div>
            @endif
        </div>
    </div>

    <!-- Security & Activity Logs -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-shield-check text-success me-2"></i> Recent Activity Logs</h5>
                <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Full Audit</a>
            </div>

            <div class="d-flex flex-column gap-2 small">
                @forelse($recentActivities as $act)
                    <div class="p-2 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-light text-dark border me-1">{{ $act->module }}</span>
                            <span class="text-dark">{{ $act->description }}</span>
                        </div>
                        <span class="text-muted text-xs">{{ $act->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No recent logs recorded.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const palette = [
            '#3b82f6', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6',
            '#06b6d4', '#6366f1', '#14b8a6', '#f97316', '#64748b'
        ];

        // 1. Revenue Bar Chart
        const ctxRev = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRev, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [{
                    label: 'Fee Collection (₹)',
                    data: {!! json_encode($monthlyRevenue) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.85)',
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 2. Admissions Line Chart
        const ctxAdm = document.getElementById('admissionsChart').getContext('2d');
        new Chart(ctxAdm, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthLabels) !!},
                datasets: [{
                    label: 'Students Enrolled',
                    data: {!! json_encode($monthlyAdmissions) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.15)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 3. Course Enrollment Doughnut Chart
        const ctxCourse = document.getElementById('coursePieChart').getContext('2d');
        new Chart(ctxCourse, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($coursePieLabels) !!},
                datasets: [{
                    data: {!! json_encode($coursePieData) !!},
                    backgroundColor: palette.slice(0, {!! count($coursePieLabels) !!}),
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 11 } }
                    }
                }
            }
        });

        // 4. Lead Status Pie Chart
        const ctxLead = document.getElementById('leadStatusPieChart').getContext('2d');
        new Chart(ctxLead, {
            type: 'pie',
            data: {
                labels: {!! json_encode($leadStatusLabels) !!},
                datasets: [{
                    data: {!! json_encode($leadStatusData) !!},
                    backgroundColor: ['#06b6d4', '#3b82f6', '#f59e0b', '#8b5cf6', '#10b981', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 11 } }
                    }
                }
            }
        });

        // 5. Payment Modes Doughnut Chart
        const ctxPay = document.getElementById('paymentModeChart').getContext('2d');
        new Chart(ctxPay, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($paymentModeLabels) !!},
                datasets: [{
                    data: {!! json_encode($paymentModeData) !!},
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ec4899', '#6366f1'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 11 } }
                    }
                }
            }
        });
    });
</script>
@endpush
