@extends('layouts.admin')

@section('title', 'Lead Analytics & Conversion Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">CRM Lead & Conversion Report</h3>
        <p class="text-muted small mb-0">Total Leads: <strong>{{ $totalEnquiries }}</strong> • Converted: <strong>{{ $convertedEnquiries }}</strong> (Conversion Rate: <strong class="text-success">{{ $conversionRate }}%</strong>)</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <h5 class="fw-bold text-primary mb-3">Leads Breakdown by Channel Source</h5>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Channel Source</th>
                            <th class="text-end">Total Leads</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bySource as $src)
                            <tr>
                                <td class="fw-semibold">{{ $src->source?->name ?? 'Direct / Website' }}</td>
                                <td class="text-end fw-bold text-primary">{{ $src->total }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center py-3 text-muted">No lead data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
            <h5 class="fw-bold text-primary mb-3">Leads Pipeline by Stage</h5>
            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Stage / Status</th>
                            <th class="text-end">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($byStatus as $st)
                            <tr>
                                <td><span class="badge bg-light text-dark border">{{ $st->status }}</span></td>
                                <td class="text-end fw-bold text-primary">{{ $st->total }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="text-center py-3 text-muted">No lead status data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
