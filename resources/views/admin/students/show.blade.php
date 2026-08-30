@extends('layouts.admin')

@section('title', 'Student Profile: ' . $student->full_name)

@section('content')
<!-- Student Top Header Banner -->
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ $student->photo ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80' }}" class="rounded-circle object-fit-cover shadow" style="width: 76px; height: 76px;" alt="{{ $student->full_name }}">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h3 class="fw-bold text-dark mb-0">{{ $student->full_name }}</h3>
                    <span class="badge bg-{{ $student->status === 'active' ? 'success' : 'secondary' }} badge-chip">{{ ucfirst($student->status) }}</span>
                </div>
                <div class="text-muted small mt-1">
                    <span class="badge bg-light text-dark border me-2">{{ $student->student_code }}</span>
                    <span><i class="bi bi-telephone me-1"></i> {{ $student->mobile }}</span>
                    @if($student->email) • <span><i class="bi bi-envelope me-1"></i> {{ $student->email }}</span>@endif
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.admissions.create', ['student_id' => $student->id]) }}" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Enroll in Course
            </a>
            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                <i class="bi bi-pencil-square me-1"></i> Edit Profile
            </a>
            <form method="POST" action="{{ route('admin.students.destroy', $student->id) }}" onsubmit="return confirm('Are you sure you want to delete this student record?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<ul class="nav nav-pills mb-4 bg-white p-2 rounded-4 shadow-sm" id="studentTab" role="tablist">
    <li class="nav-item" role="presentation"><button class="nav-link active rounded-pill fw-semibold" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab"><i class="bi bi-person-lines-fill me-1"></i> Overview</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link rounded-pill fw-semibold" id="admissions-tab" data-bs-toggle="tab" data-bs-target="#admissions" type="button" role="tab"><i class="bi bi-journal-bookmark-fill me-1"></i> Admissions ({{ $student->admissions->count() }})</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link rounded-pill fw-semibold" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab"><i class="bi bi-calendar-check me-1"></i> Attendance ({{ $student->attendance_percentage }}%)</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link rounded-pill fw-semibold" id="fees-tab" data-bs-toggle="tab" data-bs-target="#fees" type="button" role="tab"><i class="bi bi-cash-coin me-1"></i> Fees & Payments</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link rounded-pill fw-semibold" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab"><i class="bi bi-file-earmark-text me-1"></i> Documents ({{ $student->documents->count() }})</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link rounded-pill fw-semibold" id="certificates-tab" data-bs-toggle="tab" data-bs-target="#certificates" type="button" role="tab"><i class="bi bi-award me-1"></i> Certificates</button></li>
    <li class="nav-item" role="presentation"><button class="nav-link rounded-pill fw-semibold" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab"><i class="bi bi-chat-left-quote me-1"></i> Internal Notes</button></li>
</ul>

<!-- Tab Content -->
<div class="tab-content" id="studentTabContent">
    <!-- Overview Tab -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <h5 class="fw-bold text-primary mb-3">Personal & Contact Info</h5>
                    <table class="table table-sm table-borderless small mb-0">
                        <tr><th class="w-35 text-muted">Gender:</th><td class="fw-semibold">{{ $student->gender ?: 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Date of Birth:</th><td class="fw-semibold">{{ $student->dob ? $student->dob->format('d M Y') : 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Blood Group:</th><td class="fw-semibold">{{ $student->blood_group ?: 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Primary Mobile:</th><td class="fw-semibold">{{ $student->mobile }}</td></tr>
                        <tr><th class="text-muted">Alt Mobile:</th><td>{{ $student->alternate_mobile ?: 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Email:</th><td>{{ $student->email ?: 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Address:</th><td>{{ $student->address }}, {{ $student->city }}, {{ $student->state }} - {{ $student->pincode }}</td></tr>
                    </table>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                    <h5 class="fw-bold text-primary mb-3">Parent & Academic History</h5>
                    <table class="table table-sm table-borderless small mb-0">
                        <tr><th class="w-35 text-muted">Parent / Guardian:</th><td class="fw-semibold">{{ $student->parent_name ?: 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Parent Contact:</th><td class="fw-semibold">{{ $student->parent_mobile ?: 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Occupation:</th><td>{{ $student->parent_occupation ?: 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Qualification:</th><td class="fw-semibold">{{ $student->qualification ?: 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Institution:</th><td>{{ $student->institution ?: 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Passing Year:</th><td>{{ $student->passing_year ?: 'N/A' }}</td></tr>
                        <tr><th class="text-muted">Experience:</th><td>{{ $student->previous_experience ?: 'None' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Admissions Tab -->
    <div class="tab-pane fade" id="admissions" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4">
            <h5 class="fw-bold text-primary mb-3">Enrolled Admissions & Ledger</h5>
            @forelse($student->admissions as $adm)
                <div class="p-3 bg-light rounded-3 border mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                        <div>
                            <h6 class="fw-bold text-dark mb-0">{{ $adm->course?->course_name }}</h6>
                            <span class="badge bg-primary text-xs">{{ $adm->admission_number }}</span>
                            <span class="badge bg-info text-xs">{{ $adm->batch?->batch_name ?? 'No batch assigned' }}</span>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $adm->payment_status === 'Paid' ? 'success' : ($adm->payment_status === 'Partially Paid' ? 'warning' : 'danger') }}">{{ $adm->payment_status }}</span>
                            <a href="{{ route('admin.admissions.show', $adm->id) }}" class="btn btn-sm btn-outline-primary ms-2 rounded-pill">View Invoice</a>
                        </div>
                    </div>
                    <div class="row g-2 small text-muted pt-2 border-top">
                        <div class="col-sm-3">Course Fee: <strong class="text-dark">₹{{ number_format($adm->course_fee) }}</strong></div>
                        <div class="col-sm-3">Discount: <strong class="text-success">₹{{ number_format($adm->discount) }}</strong></div>
                        <div class="col-sm-3">Total Paid: <strong class="text-primary">₹{{ number_format($adm->total_paid) }}</strong></div>
                        <div class="col-sm-3">Balance Due: <strong class="text-danger">₹{{ number_format($adm->balance) }}</strong></div>
                    </div>
                </div>
            @empty
                <p class="text-muted small mb-0">No course admissions recorded yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Attendance Tab -->
    <div class="tab-pane fade" id="attendance" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-primary mb-0">Daily Attendance History</h5>
                <span class="badge bg-success px-3 py-2 rounded-pill">{{ $student->attendance_percentage }}% Overall Attendance</span>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle small">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Batch</th>
                            <th>Status</th>
                            <th>Check-in</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($student->attendances->sortByDesc('attendance_date') as $att)
                            <tr>
                                <td>{{ $att->attendance_date->format('d M Y') }}</td>
                                <td>{{ $att->batch?->batch_name }}</td>
                                <td><span class="badge bg-{{ $att->status === 'Present' ? 'success' : ($att->status === 'Late' ? 'warning' : 'danger') }}">{{ $att->status }}</span></td>
                                <td>{{ $att->check_in_time ?: '-' }}</td>
                                <td>{{ $att->remarks ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No attendance marked yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Fees & Payments Tab -->
    <div class="tab-pane fade" id="fees" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-primary mb-0">Payment Receipts History</h5>
                <a href="{{ route('admin.payments.create') }}" class="btn btn-sm btn-success rounded-pill px-3">
                    <i class="bi bi-plus-circle me-1"></i> Record New Payment
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle small">
                    <thead class="table-light">
                        <tr>
                            <th>Receipt No</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Transaction Ref</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($student->payments as $pay)
                            <tr>
                                <td class="fw-bold text-primary">{{ $pay->receipt_number }}</td>
                                <td>{{ $pay->payment_date->format('d M Y') }}</td>
                                <td class="fw-bold text-success">₹{{ number_format($pay->amount) }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $pay->payment_method }}</span></td>
                                <td>{{ $pay->transaction_number ?: 'N/A' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.payments.receipt', $pay->id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-2" title="Print Receipt">
                                        <i class="bi bi-printer-fill me-1"></i> Receipt
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No payment transactions found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Documents Tab -->
    <div class="tab-pane fade" id="documents" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-primary mb-3">Uploaded Student Documents</h5>

            <!-- Upload Form -->
            <form method="POST" action="{{ route('admin.students.documents.upload', $student->id) }}" enctype="multipart/form-data" class="p-3 bg-light rounded-3 mb-4">
                @csrf
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Document Title</label>
                        <input type="text" name="title" class="form-control form-control-sm rounded-3" required placeholder="Aadhaar Card, Marksheet...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Type</label>
                        <select name="document_type" class="form-select form-select-sm rounded-3">
                            <option value="ID Proof">ID Proof</option>
                            <option value="Marksheet">Marksheet / Certificate</option>
                            <option value="Photo">Photo</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Select File (PDF, Image)</label>
                        <input type="file" name="document_file" class="form-control form-control-sm rounded-3" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3"><i class="bi bi-upload me-1"></i> Upload</button>
                    </div>
                </div>
            </form>

            <div class="row g-3">
                @forelse($student->documents as $doc)
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded-3 border d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="d-block text-dark small">{{ $doc->title }}</strong>
                                <span class="badge bg-light text-muted border text-xs">{{ $doc->document_type }}</span>
                            </div>
                            <div class="d-flex gap-1">
                                <a href="{{ $doc->file_path }}" target="_blank" class="btn btn-sm btn-outline-primary" title="View Document"><i class="bi bi-eye"></i></a>
                                <form method="POST" action="{{ route('admin.students.documents.delete', [$student->id, $doc->id]) }}" onsubmit="return confirm('Delete this document?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small mb-0 ps-2">No documents uploaded.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Certificates Tab -->
    <div class="tab-pane fade" id="certificates" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-primary mb-3">Issued Course Certificates</h5>
            @forelse($student->certificates as $cert)
                <div class="p-3 bg-light rounded-3 border d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <strong class="d-block text-dark">{{ $cert->course?->course_name }}</strong>
                        <span class="badge bg-primary text-xs me-2">No: {{ $cert->certificate_number }}</span>
                        <span class="badge bg-success text-xs">Grade: {{ $cert->grade }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.certificates.print', $cert->id) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="bi bi-printer-fill me-1"></i> Print Certificate
                        </a>
                        <a href="{{ route('certificate.verify', $cert->verification_code) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="bi bi-shield-check me-1"></i> Verify Link
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-muted small mb-0">No certificates generated yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Notes Tab -->
    <div class="tab-pane fade" id="notes" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold text-primary mb-3">Internal Staff Notes</h5>
            <form method="POST" action="{{ route('admin.students.notes.store', $student->id) }}" class="mb-4">
                @csrf
                <div class="mb-2">
                    <textarea name="note" class="form-control rounded-3" rows="3" required placeholder="Add private remark or note about student performance, fees, attendance..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4"><i class="bi bi-plus-circle me-1"></i> Add Note</button>
            </form>

            <div class="d-flex flex-column gap-2 small">
                @forelse($student->notes->sortByDesc('created_at') as $nt)
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-dark">{{ $nt->author?->name ?? 'Staff' }}</strong>
                            <span class="text-muted text-xs">{{ $nt->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-dark mb-0">{{ $nt->note }}</p>
                    </div>
                @empty
                    <p class="text-muted small mb-0">No internal notes added.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
