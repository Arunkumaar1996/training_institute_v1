@extends('layouts.admin')

@section('title', 'Student Admissions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Admissions & Enrolled Ledger</h3>
        <p class="text-muted small mb-0">Track course admissions, fee settlements, discounts, and balances</p>
    </div>
    <a href="{{ route('admin.admissions.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
        <i class="bi bi-person-plus-fill me-1"></i> New Admission
    </a>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.admissions.index') }}">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light" value="{{ request('search') }}" placeholder="Search admission no, student name, ID...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="payment_status" class="form-select bg-light">
                    <option value="">All Payment Statuses</option>
                    <option value="Paid" {{ request('payment_status') === 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Partially Paid" {{ request('payment_status') === 'Partially Paid' ? 'selected' : '' }}>Partially Paid</option>
                    <option value="Pending" {{ request('payment_status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Overdue" {{ request('payment_status') === 'Overdue' ? 'selected' : '' }}>Overdue</option>
                </select>
            </div>
            <div class="col-6 col-md-3">
                <select name="course_id" class="form-select bg-light">
                    <option value="">All Courses</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->course_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill"></i></button>
            </div>
        </div>
    </form>
</div>

<!-- Admissions Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Admission No</th>
                    <th>Student</th>
                    <th>Course & Batch</th>
                    <th>Date</th>
                    <th>Final Fee</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admissions as $adm)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('admin.admissions.show', $adm->id) }}" class="fw-bold text-primary text-decoration-none">{{ $adm->admission_number }}</a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $adm->student?->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80' }}" class="rounded-circle object-fit-cover" style="width: 32px; height: 32px;" alt="{{ $adm->student?->full_name }}">
                                <div>
                                    <a href="{{ route('admin.students.show', $adm->student_id) }}" class="fw-semibold text-dark text-decoration-none d-block small">{{ $adm->student?->full_name }}</a>
                                    <span class="text-muted text-xs">{{ $adm->student?->student_code }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <div class="fw-semibold text-dark">{{ $adm->course?->course_name }}</div>
                                <span class="text-muted">{{ $adm->batch?->batch_name ?? 'No batch' }}</span>
                            </div>
                        </td>
                        <td class="small">{{ $adm->admission_date->format('d M Y') }}</td>
                        <td class="small fw-semibold">₹{{ number_format($adm->final_fee) }}</td>
                        <td class="small fw-bold text-success">₹{{ number_format($adm->total_paid) }}</td>
                        <td class="small fw-bold text-{{ $adm->balance > 0 ? 'danger' : 'muted' }}">₹{{ number_format($adm->balance) }}</td>
                        <td>
                            <span class="badge bg-{{ $adm->payment_status === 'Paid' ? 'success' : ($adm->payment_status === 'Partially Paid' ? 'warning' : 'danger') }} badge-chip">
                                {{ $adm->payment_status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.admissions.show', $adm->id) }}" class="btn btn-outline-primary" title="View Admission Invoice"><i class="bi bi-eye"></i></a>
                                @if($adm->balance > 0)
                                    <a href="{{ route('admin.payments.create', ['admission_id' => $adm->id]) }}" class="btn btn-outline-success" title="Collect Payment"><i class="bi bi-credit-card"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">No admission records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $admissions->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
