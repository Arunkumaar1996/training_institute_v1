@extends('layouts.admin')

@section('title', 'Certificates Registry')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Certificate Registry & Issuance</h3>
        <p class="text-muted small mb-0">Generate, track, and verify authorized student completion certificates</p>
    </div>
    <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
        <i class="bi bi-award-fill me-1"></i> Issue Certificate
    </a>
</div>

<!-- Search & Filters -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.certificates.index') }}">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light" value="{{ request('search') }}" placeholder="Search certificate number (CRT-...), verification code, student name...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="course_id" class="form-select bg-light">
                    <option value="">All Courses</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->course_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="status" class="form-select bg-light">
                    <option value="">All Statuses</option>
                    <option value="Issued" {{ request('status') === 'Issued' ? 'selected' : '' }}>Issued</option>
                    <option value="Revoked" {{ request('status') === 'Revoked' ? 'selected' : '' }}>Revoked</option>
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel-fill"></i></button>
            </div>
        </div>
    </form>
</div>

<!-- Certificates Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Certificate No</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Issue Date</th>
                    <th>Grade</th>
                    <th>Verification Code</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($certificates as $cert)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('admin.certificates.show', $cert->id) }}" class="fw-bold text-primary text-decoration-none">{{ $cert->certificate_number }}</a>
                        </td>
                        <td>
                            <a href="{{ route('admin.students.show', $cert->student_id) }}" class="fw-bold text-dark text-decoration-none d-block small">{{ $cert->student?->full_name }}</a>
                            <small class="text-muted">{{ $cert->student?->student_code }}</small>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $cert->course?->course_name }}</span></td>
                        <td class="small">{{ $cert->issue_date->format('d M Y') }}</td>
                        <td><span class="badge bg-light text-dark border fw-bold">{{ $cert->grade }}</span></td>
                        <td><code>{{ $cert->verification_code }}</code></td>
                        <td>
                            <span class="badge bg-{{ $cert->status === 'Issued' ? 'success' : 'danger' }} badge-chip">
                                {{ $cert->status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.certificates.print', $cert->id) }}" target="_blank" class="btn btn-outline-dark" title="Print Certificate"><i class="bi bi-printer-fill"></i></a>
                                <a href="{{ route('certificate.verify', $cert->verification_code) }}" target="_blank" class="btn btn-outline-primary" title="Online Public Verification"><i class="bi bi-shield-check"></i></a>
                                <a href="{{ route('admin.certificates.show', $cert->id) }}" class="btn btn-outline-secondary" title="View Details"><i class="bi bi-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No certificates generated yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $certificates->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
