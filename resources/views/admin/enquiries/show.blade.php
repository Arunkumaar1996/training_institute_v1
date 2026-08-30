@extends('layouts.admin')

@section('title', 'Lead: ' . $enquiry->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <div class="d-flex align-items-center gap-2">
            <h3 class="fw-bold text-dark mb-0">{{ $enquiry->name }}</h3>
            <span class="badge bg-{{ $enquiry->status === 'Converted' ? 'success' : 'warning' }} badge-chip">{{ $enquiry->status }}</span>
        </div>
        <p class="text-muted small mb-0">Code: {{ $enquiry->enquiry_code }} • Registered: {{ $enquiry->created_at->format('d M Y') }}</p>
    </div>
    <div class="d-flex gap-2">
        @if($enquiry->status !== 'Converted')
            <form method="POST" action="{{ route('admin.enquiries.convert', $enquiry->id) }}">
                @csrf
                <button type="submit" class="btn btn-success rounded-pill px-3 shadow-sm">
                    <i class="bi bi-person-check-fill me-1"></i> Convert to Registered Student
                </button>
            </form>
        @else
            @if($enquiry->converted_student_id)
                <a href="{{ route('admin.students.show', $enquiry->converted_student_id) }}" class="btn btn-outline-success rounded-pill px-3">
                    <i class="bi bi-person-lines-fill me-1"></i> View Converted Student Profile
                </a>
            @endif
        @endif
        <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Lead Info & Quick Status Change -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-primary mb-3">Lead Information</h5>
            <table class="table table-sm table-borderless small mb-4">
                <tr><th class="w-35 text-muted">Mobile:</th><td class="fw-bold">{{ $enquiry->mobile }}</td></tr>
                <tr><th class="text-muted">Email:</th><td>{{ $enquiry->email ?: 'N/A' }}</td></tr>
                <tr><th class="text-muted">City:</th><td>{{ $enquiry->city ?: 'N/A' }}</td></tr>
                <tr><th class="text-muted">Course Interested:</th><td class="fw-bold text-primary">{{ $enquiry->course?->course_name ?? 'General' }}</td></tr>
                <tr><th class="text-muted">Lead Source:</th><td><span class="badge bg-light text-dark border">{{ $enquiry->source?->name ?? 'Direct' }}</span></td></tr>
                <tr><th class="text-muted">Assigned Counselor:</th><td>{{ $enquiry->assignedUser?->name ?? 'General Pool' }}</td></tr>
                @if($enquiry->message)<tr><th class="text-muted">Message:</th><td class="text-muted">{{ $enquiry->message }}</td></tr>@endif
            </table>

            <!-- Update Status Form -->
            <form method="POST" action="{{ route('admin.enquiries.update-status', $enquiry->id) }}" class="border-top pt-3">
                @csrf
                <label class="form-label small fw-semibold text-muted">Update Lead Stage</label>
                <div class="input-group">
                    <select name="status" class="form-select form-select-sm rounded-start-3">
                        <option value="New" {{ $enquiry->status === 'New' ? 'selected' : '' }}>New</option>
                        <option value="Contacted" {{ $enquiry->status === 'Contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="Interested" {{ $enquiry->status === 'Interested' ? 'selected' : '' }}>Interested</option>
                        <option value="Demo Scheduled" {{ $enquiry->status === 'Demo Scheduled' ? 'selected' : '' }}>Demo Scheduled</option>
                        <option value="Converted" {{ $enquiry->status === 'Converted' ? 'selected' : '' }}>Converted</option>
                        <option value="Closed / Lost" {{ $enquiry->status === 'Closed / Lost' ? 'selected' : '' }}>Closed / Lost</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm rounded-end-3">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Follow-up Activity Timeline -->
    <div class="col-lg-7">
        <!-- Add Follow-up Form -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-telephone-plus me-2"></i> Log Follow-up Activity</h5>
            <form method="POST" action="{{ route('admin.enquiries.followup.store', $enquiry->id) }}">
                @csrf
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Contact Medium</label>
                        <select name="contact_medium" class="form-select form-select-sm rounded-3">
                            <option value="Call">Phone Call</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Email">Email</option>
                            <option value="In-person Visit">In-person Visit</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Next Follow-up Date</label>
                        <input type="date" name="next_follow_up" class="form-control form-control-sm rounded-3" value="{{ now()->addDays(2)->toDateString() }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Response / Outcome</label>
                        <select name="response" class="form-select form-select-sm rounded-3">
                            <option value="Positive">Positive</option>
                            <option value="Neutral">Neutral</option>
                            <option value="Negative">Negative</option>
                            <option value="No Answer">No Answer / Busy</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold">Call Remarks / Discussion Notes <span class="text-danger">*</span></label>
                        <textarea name="remarks" class="form-control form-control-sm rounded-3" rows="2" required placeholder="Details of conversation, next action..."></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4"><i class="bi bi-plus-circle me-1"></i> Save Follow-up</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Follow-ups History -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-primary mb-3"><i class="bi bi-clock-history me-2"></i> Follow-up History ({{ $enquiry->followUps->count() }})</h5>
            <div class="d-flex flex-column gap-3">
                @forelse($enquiry->followUps->sortByDesc('created_at') as $fu)
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <span class="badge bg-primary-subtle text-primary">{{ $fu->contact_medium }}</span>
                                <span class="badge bg-{{ $fu->response === 'Positive' ? 'success' : 'secondary' }} ms-1">{{ $fu->response }}</span>
                            </div>
                            <small class="text-muted text-xs">{{ $fu->created_at->diffForHumans() }} by {{ $fu->staff?->name ?? 'Staff' }}</small>
                        </div>
                        <p class="text-dark small mb-1">{{ $fu->remarks }}</p>
                        @if($fu->next_follow_up)
                            <small class="text-muted text-xs"><i class="bi bi-calendar-event me-1"></i> Next Follow-up: <strong>{{ $fu->next_follow_up->format('d M Y') }}</strong></small>
                        @endif
                    </div>
                @empty
                    <p class="text-muted small mb-0">No follow-up activities recorded yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
