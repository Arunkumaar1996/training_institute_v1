@extends('layouts.admin')

@section('title', 'Admissions Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Student Admissions Report</h3>
        <p class="text-muted small mb-0">Total Enrolled in Period: <strong class="text-primary fs-6">{{ $admissions->count() }} Students</strong></p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-3"><i class="bi bi-printer me-1"></i> Print</button>
        <a href="{{ route('admin.reports.admissions', array_merge(request()->all(), ['export' => 'csv'])) }}" class="btn btn-success rounded-pill px-3"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Export CSV</a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.reports.admissions') }}">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control bg-light" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control bg-light" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <select name="course_id" class="form-select bg-light">
                    <option value="">All Courses</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->course_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary rounded-3"><i class="bi bi-funnel-fill me-1"></i> Filter</button>
            </div>
        </div>
    </form>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Admission No</th>
                    <th>Date</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Final Fee</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admissions as $adm)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">{{ $adm->admission_number }}</td>
                        <td>{{ $adm->admission_date->format('d M Y') }}</td>
                        <td>{{ $adm->student?->full_name }}</td>
                        <td>{{ $adm->course?->course_name }}</td>
                        <td>₹{{ number_format($adm->final_fee) }}</td>
                        <td class="text-success fw-bold">₹{{ number_format($adm->total_paid) }}</td>
                        <td class="text-danger fw-bold">₹{{ number_format($adm->balance) }}</td>
                        <td><span class="badge bg-{{ $adm->payment_status === 'Paid' ? 'success' : 'warning' }}">{{ $adm->payment_status }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No admissions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
