@extends('layouts.admin')

@section('title', 'Student Daily Batch Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0">Student Batch Attendance</h3>
        <p class="text-muted small mb-0">Record daily lab and classroom attendance for active training batches</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.attendance.employees') }}" class="btn btn-outline-primary rounded-pill px-3">
            <i class="bi bi-person-badge me-1"></i> Staff Attendance
        </a>
        <a href="{{ route('admin.attendance.reports') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-bar-chart me-1"></i> Attendance % Reports
        </a>
    </div>
</div>

<!-- Select Batch & Date Form -->
<div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form method="GET" action="{{ route('admin.attendance.students') }}" class="row g-3 align-items-center">
        <div class="col-md-6">
            <label class="form-label small fw-semibold text-muted mb-1">Select Batch</label>
            <select name="batch_id" class="form-select bg-light" onchange="this.form.submit()">
                <option value="">-- Choose Batch to Mark Attendance --</option>
                @foreach($batches as $b)
                    <option value="{{ $b->id }}" {{ $selectedBatch?->id == $b->id ? 'selected' : '' }}>
                        {{ $b->batch_name }} ({{ $b->course?->course_name }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-semibold text-muted mb-1">Attendance Date</label>
            <input type="date" name="date" class="form-control bg-light" value="{{ $date }}" onchange="this.form.submit()">
        </div>
        <div class="col-md-2 d-grid align-self-end">
            <button type="submit" class="btn btn-primary rounded-3"><i class="bi bi-arrow-repeat me-1"></i> Load Matrix</button>
        </div>
    </form>
</div>

@if($selectedBatch)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h5 class="fw-bold text-dark mb-0">{{ $selectedBatch->batch_name }}</h5>
                <small class="text-muted">Total Enrolled: <strong>{{ $selectedBatch->students->count() }} Students</strong> • Date: <strong>{{ date('d M Y', strtotime($date)) }}</strong></small>
            </div>

            <!-- Quick Batch Buttons -->
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold" id="btnMarkAllPresent">
                    <i class="bi bi-check-all me-1"></i> Mark All Present
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold" id="btnMarkAllAbsent">
                    <i class="bi bi-x-circle me-1"></i> Mark All Absent
                </button>
            </div>
        </div>

        <div id="attendanceAlert" class="alert d-none" role="alert"></div>

        <form id="saveAttendanceForm">
            @csrf
            <input type="hidden" name="batch_id" value="{{ $selectedBatch->id }}">
            <input type="hidden" name="attendance_date" value="{{ $date }}">

            <div class="table-responsive mb-4">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Student Name</th>
                            <th>Student ID</th>
                            <th class="text-center">Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($selectedBatch->students as $index => $stu)
                            @php $currentStatus = $attendances[$stu->id] ?? 'Present'; @endphp
                            <tr>
                                <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <strong class="text-dark d-block">{{ $stu->full_name }}</strong>
                                    <small class="text-muted">{{ $stu->mobile }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $stu->student_code }}</span></td>
                                <td class="text-center" style="min-width: 260px;">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <input type="radio" class="btn-check status-radio status-present" name="records[{{ $stu->id }}][status]" id="pres_{{ $stu->id }}" value="Present" {{ $currentStatus === 'Present' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success" for="pres_{{ $stu->id }}"><i class="bi bi-check-lg"></i> Present</label>

                                        <input type="radio" class="btn-check status-radio status-late" name="records[{{ $stu->id }}][status]" id="late_{{ $stu->id }}" value="Late" {{ $currentStatus === 'Late' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning" for="late_{{ $stu->id }}"><i class="bi bi-clock"></i> Late</label>

                                        <input type="radio" class="btn-check status-radio status-absent" name="records[{{ $stu->id }}][status]" id="abs_{{ $stu->id }}" value="Absent" {{ $currentStatus === 'Absent' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-danger" for="abs_{{ $stu->id }}"><i class="bi bi-x"></i> Absent</label>

                                        <input type="radio" class="btn-check status-radio status-leave" name="records[{{ $stu->id }}][status]" id="leave_{{ $stu->id }}" value="Leave" {{ $currentStatus === 'Leave' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-secondary" for="leave_{{ $stu->id }}">Leave</label>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="records[{{ $stu->id }}][remarks]" class="form-control form-control-sm rounded-3" placeholder="Optional notes...">
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No students assigned to this batch yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($selectedBatch->students->isNotEmpty())
                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                    <button type="submit" id="btnSubmitAttendance" class="btn btn-primary px-5 rounded-pill fw-bold shadow">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="attSpinner" role="status"></span>
                        <i class="bi bi-cloud-arrow-up-fill me-1"></i> Save Daily Attendance
                    </button>
                </div>
            @endif
        </form>
    </div>
@else
    <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
        <i class="bi bi-calendar2-check fs-1 text-muted d-block mb-3"></i>
        <h5 class="fw-bold text-dark">Please Select a Batch</h5>
        <p class="text-muted small">Choose a training batch from the dropdown above to load the student attendance list.</p>
    </div>
@endif
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#btnMarkAllPresent').on('click', function() {
            $('.status-present').prop('checked', true);
        });

        $('#btnMarkAllAbsent').on('click', function() {
            $('.status-absent').prop('checked', true);
        });

        $('#saveAttendanceForm').on('submit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const $btn = $('#btnSubmitAttendance');
            const $spinner = $('#attSpinner');
            const $alert = $('#attendanceAlert');

            $btn.prop('disabled', true);
            $spinner.removeClass('d-none');
            $alert.addClass('d-none').removeClass('alert-success alert-danger');

            $.ajax({
                url: "{{ route('admin.attendance.students.save') }}",
                type: "POST",
                data: $form.serialize(),
                success: function(res) {
                    $alert.removeClass('d-none').addClass('alert-success')
                        .html('<i class="bi bi-check-circle-fill me-2"></i> ' + res.message);
                },
                error: function(xhr) {
                    $alert.removeClass('d-none').addClass('alert-danger')
                        .html('<i class="bi bi-exclamation-triangle-fill me-2"></i> Error saving attendance.');
                },
                complete: function() {
                    $btn.prop('disabled', false);
                    $spinner.addClass('d-none');
                }
            });
        });
    });
</script>
@endpush
