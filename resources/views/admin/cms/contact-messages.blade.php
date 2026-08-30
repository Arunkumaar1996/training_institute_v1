@extends('layouts.admin')

@section('title', 'Website Inquiries & Contact Messages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Website Contact Inquiries</h3>
        <p class="text-muted small mb-0">Messages submitted through the public website contact form</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Sender</th>
                    <th>Mobile & Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date Received</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $msg->name }}</td>
                        <td>
                            <div class="small">
                                <div><i class="bi bi-telephone text-muted me-1"></i> {{ $msg->mobile ?: 'N/A' }}</div>
                                <div><i class="bi bi-envelope text-muted me-1"></i> {{ $msg->email }}</div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $msg->subject ?: 'General Inquiry' }}</span></td>
                        <td><small class="text-muted">{{ Str::limit($msg->message, 80) }}</small></td>
                        <td class="small">{{ $msg->created_at->format('d M Y, h:i A') }}</td>
                        <td>
                            <span class="badge bg-{{ $msg->is_read ? 'light text-muted border' : 'primary' }}">
                                {{ $msg->is_read ? 'Read' : 'New' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <form method="POST" action="{{ route('admin.cms.contact-messages.destroy', $msg->id) }}" onsubmit="return confirm('Delete this message?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No contact messages received yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $messages->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
