@extends('layouts.admin')

@section('title', 'Certificate: ' . $certificate->certificate_number)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Certificate Record: {{ $certificate->certificate_number }}</h3>
        <p class="text-muted small mb-0">Issued on {{ $certificate->issue_date->format('d F Y') }} to {{ $certificate->student?->full_name }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.certificates.print', $certificate->id) }}" target="_blank" class="btn btn-dark rounded-pill px-3 shadow-sm">
            <i class="bi bi-printer-fill me-1"></i> Print / Download
        </a>
        <a href="{{ route('certificate.verify', $certificate->verification_code) }}" target="_blank" class="btn btn-outline-primary rounded-pill px-3">
            <i class="bi bi-shield-check me-1"></i> Online Verification Link
        </a>
        <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <div class="table-responsive">
        <table class="table table-bordered mb-4">
            <tbody>
                <tr>
                    <th class="w-30 bg-light">Certificate Number</th>
                    <td class="fw-bold text-primary">{{ $certificate->certificate_number }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Verification Code</th>
                    <td><code>{{ $certificate->verification_code }}</code></td>
                </tr>
                <tr>
                    <th class="bg-light">Student Name</th>
                    <td class="fw-bold fs-5">{{ $certificate->student?->full_name }} ({{ $certificate->student?->student_code }})</td>
                </tr>
                <tr>
                    <th class="bg-light">Course Completed</th>
                    <td class="fw-semibold">{{ $certificate->course?->course_name }} ({{ $certificate->course?->level }})</td>
                </tr>
                <tr>
                    <th class="bg-light">Issue Date</th>
                    <td>{{ $certificate->issue_date->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Grade Awarded</th>
                    <td><span class="badge bg-primary px-3 py-2 fs-6">{{ $certificate->grade }}</span></td>
                </tr>
                <tr>
                    <th class="bg-light">Current Status</th>
                    <td>
                        <span class="badge bg-{{ $certificate->status === 'Issued' ? 'success' : 'danger' }} px-3 py-2 fs-6">
                            {{ $certificate->status }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($certificate->status === 'Issued')
        <form method="POST" action="{{ route('admin.certificates.revoke', $certificate->id) }}" onsubmit="return confirm('Are you sure you want to revoke this certificate?');">
            @csrf
            <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                <i class="bi bi-x-octagon me-1"></i> Revoke Certificate Credential
            </button>
        </form>
    @endif
</div>
@endsection
