@extends('layouts.admin')

@section('title', 'Security Audit Logs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0"><i class="bi bi-shield-check text-success me-2"></i> Security & Activity Audit Trail</h3>
        <p class="text-muted small mb-0">Immutable compliance logs tracking user actions, IP addresses, and database events</p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Timestamp</th>
                    <th>User</th>
                    <th>Module</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="ps-4 text-muted">{{ $log->created_at->format('d M Y, h:i:s A') }}</td>
                        <td>
                            <strong class="text-dark">{{ $log->user?->name ?? 'System' }}</strong>
                            <small class="text-muted d-block">{{ $log->user?->email }}</small>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $log->module }}</span></td>
                        <td><span class="badge bg-light text-dark border">{{ $log->action }}</span></td>
                        <td>{{ $log->description }}</td>
                        <td><code>{{ $log->ip_address }}</code></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No activity logs recorded.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
