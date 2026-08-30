@extends('layouts.admin')

@section('title', 'Leads & Enquiries CRM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Enquiries & Leads CRM</h3>
        <p class="text-muted small mb-0">Manage prospect inquiries, follow-up schedules, and admissions conversion</p>
    </div>
    <a href="{{ route('admin.enquiries.create') }}" class="btn btn-primary rounded-pill px-3 shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Add Enquiry
    </a>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.enquiries.index') }}">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light" value="{{ request('search') }}" placeholder="Search lead name, code (ENQ-...), mobile...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select bg-light">
                    <option value="">All Lead Statuses</option>
                    <option value="New" {{ request('status') === 'New' ? 'selected' : '' }}>New</option>
                    <option value="Contacted" {{ request('status') === 'Contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="Interested" {{ request('status') === 'Interested' ? 'selected' : '' }}>Interested</option>
                    <option value="Demo Scheduled" {{ request('status') === 'Demo Scheduled' ? 'selected' : '' }}>Demo Scheduled</option>
                    <option value="Converted" {{ request('status') === 'Converted' ? 'selected' : '' }}>Converted</option>
                    <option value="Closed / Lost" {{ request('status') === 'Closed / Lost' ? 'selected' : '' }}>Closed / Lost</option>
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

<!-- Enquiries Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Lead Name</th>
                    <th>Code</th>
                    <th>Contact</th>
                    <th>Course Interested</th>
                    <th>Next Follow-up</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enquiries as $enq)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('admin.enquiries.show', $enq->id) }}" class="fw-bold text-dark text-decoration-none d-block">{{ $enq->name }}</a>
                            <small class="text-muted">{{ $enq->city ?: 'Enquiry' }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $enq->enquiry_code }}</span></td>
                        <td>
                            <div class="small">
                                <div><i class="bi bi-telephone text-muted me-1"></i> {{ $enq->mobile }}</div>
                                @if($enq->email)<small class="text-muted">{{ $enq->email }}</small>@endif
                            </div>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $enq->course?->course_name ?? 'General' }}</span></td>
                        <td>
                            @if($enq->next_follow_up)
                                <span class="badge bg-{{ $enq->next_follow_up->isPast() ? 'danger-subtle text-danger' : 'warning-subtle text-warning' }}">
                                    <i class="bi bi-clock me-1"></i> {{ $enq->next_follow_up->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $enq->status === 'Converted' ? 'success' : ($enq->status === 'New' ? 'info' : 'warning') }} badge-chip">
                                {{ $enq->status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.enquiries.show', $enq->id) }}" class="btn btn-outline-primary" title="View & Follow Up"><i class="bi bi-eye"></i></a>
                                @if($enq->status !== 'Converted')
                                    <form method="POST" action="{{ route('admin.enquiries.convert', $enq->id) }}" onsubmit="return confirm('Convert this enquiry to a registered student?');" class="d-inline ms-1">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success" title="Convert to Student"><i class="bi bi-person-check"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No leads found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $enquiries->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
