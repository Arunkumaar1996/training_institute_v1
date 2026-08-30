@extends('layouts.admin')

@section('title', 'Add New Lead / Enquiry')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-0">Record Prospective Lead</h3>
        <p class="text-muted small mb-0">Capture student interest, lead source, and schedule first follow-up</p>
    </div>
    <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Leads
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
    <form method="POST" action="{{ route('admin.enquiries.store') }}">
        @csrf

        <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Prospect Information</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Prospect Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control rounded-3" value="{{ old('name') }}" required placeholder="e.g. Rahul Sharma">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                <input type="tel" name="mobile" class="form-control rounded-3" value="{{ old('mobile') }}" required placeholder="10-digit number">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email" class="form-control rounded-3" value="{{ old('email') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">City / Location</label>
                <input type="text" name="city" class="form-control rounded-3" value="{{ old('city') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Course Interested</label>
                <select name="course_id" class="form-select rounded-3">
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}">{{ $c->course_name }} ({{ $c->level }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Lead Source</label>
                <select name="source_id" class="form-select rounded-3">
                    <option value="">-- Choose Source --</option>
                    @foreach($sources as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Lead Stage / Status</label>
                <select name="status" class="form-select rounded-3">
                    <option value="New" selected>New</option>
                    <option value="Contacted">Contacted</option>
                    <option value="Interested">Interested</option>
                    <option value="Demo Scheduled">Demo Scheduled</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Schedule Next Follow-up</label>
                <input type="date" name="next_follow_up" class="form-control rounded-3" value="{{ old('next_follow_up', now()->addDays(1)->toDateString()) }}">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Inquiry Message / Requirement</label>
                <textarea name="message" class="form-control rounded-3" rows="3" placeholder="Notes about student requirement, preferred batch, or fee discussion..."></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="{{ route('admin.enquiries.index') }}" class="btn btn-secondary px-4 rounded-pill">Cancel</a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold shadow-sm">Save Lead</button>
        </div>
    </form>
</div>
@endsection
