<div class="card border-2 border-success shadow-lg rounded-4 overflow-hidden bg-white text-dark p-4 p-md-5">
    <div class="text-center mb-4">
        <div class="bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
            <i class="bi bi-patch-check-fill fs-1"></i>
        </div>
        <span class="badge bg-success px-3 py-2 rounded-pill fw-bold text-uppercase mb-2">Authentic & Verified Certificate</span>
        <h3 class="fw-bold text-dark mb-1">{{ \App\Models\Setting::get('institute_name', 'TechMaster Training Institute') }}</h3>
        <p class="text-muted small">Certificate Verification Registry Record</p>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered mb-4">
            <tbody>
                <tr>
                    <th class="bg-light w-35 text-dark">Certificate Number</th>
                    <td class="fw-bold text-primary">{{ $certificate->certificate_number }}</td>
                </tr>
                <tr>
                    <th class="bg-light text-dark">Student Name</th>
                    <td class="fw-bold fs-5 text-dark">{{ $certificate->student?->full_name }}</td>
                </tr>
                <tr>
                    <th class="bg-light text-dark">Student Code / ID</th>
                    <td>{{ $certificate->student?->student_code }}</td>
                </tr>
                <tr>
                    <th class="bg-light text-dark">Course Completed</th>
                    <td class="fw-semibold text-dark">{{ $certificate->course?->course_name }} ({{ $certificate->course?->level }})</td>
                </tr>
                <tr>
                    <th class="bg-light text-dark">Issue Date</th>
                    <td>{{ $certificate->issue_date->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th class="bg-light text-dark">Grade / Evaluation</th>
                    <td><span class="badge bg-primary px-3 py-1">{{ $certificate->grade }}</span></td>
                </tr>
                <tr>
                    <th class="bg-light text-dark">Certificate Status</th>
                    <td><span class="badge bg-success px-3 py-1"><i class="bi bi-check-circle-fill me-1"></i> {{ $certificate->status }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center gap-3">
        <button onclick="window.print()" class="btn btn-outline-dark px-4 rounded-pill">
            <i class="bi bi-printer-fill me-1"></i> Print Verification Record
        </button>
    </div>
</div>
