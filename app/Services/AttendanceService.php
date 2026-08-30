<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Batch;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    /**
     * Submit batch student attendance with duplicate prevention
     */
    public function saveBatchAttendance(int $batchId, string $date, array $records, ?int $markedBy = null): int
    {
        return DB::transaction(function () use ($batchId, $date, $records, $markedBy) {
            $batch = Batch::findOrFail($batchId);
            $savedCount = 0;

            foreach ($records as $studentId => $details) {
                $status = is_array($details) ? ($details['status'] ?? 'Present') : $details;
                $remarks = is_array($details) ? ($details['remarks'] ?? null) : null;
                $checkIn = is_array($details) ? ($details['check_in_time'] ?? null) : null;
                $checkOut = is_array($details) ? ($details['check_out_time'] ?? null) : null;

                StudentAttendance::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'batch_id' => $batchId,
                        'attendance_date' => $date,
                    ],
                    [
                        'course_id' => $batch->course_id,
                        'trainer_id' => $batch->trainer_id,
                        'status' => $status,
                        'check_in_time' => $checkIn,
                        'check_out_time' => $checkOut,
                        'remarks' => $remarks,
                        'marked_by' => $markedBy ?? auth()->id(),
                    ]
                );
                $savedCount++;
            }

            ActivityLog::log('updated', 'Attendance', $batchId, "Attendance marked for batch #{$batch->batch_code} on {$date} for {$savedCount} students");

            return $savedCount;
        });
    }

    /**
     * Mark all enrolled students in a batch with a single status (e.g. Present All)
     */
    public function markAllBatchStudents(int $batchId, string $date, string $status = 'Present', ?int $markedBy = null): int
    {
        $batch = Batch::with('students')->findOrFail($batchId);
        $records = [];
        foreach ($batch->students as $student) {
            $records[$student->id] = ['status' => $status];
        }

        return $this->saveBatchAttendance($batchId, $date, $records, $markedBy);
    }

    /**
     * Submit employee attendance
     */
    public function saveEmployeeAttendance(int $employeeId, string $date, string $status, ?string $checkIn = null, ?string $checkOut = null, ?string $remarks = null): EmployeeAttendance
    {
        return EmployeeAttendance::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'attendance_date' => $date,
            ],
            [
                'status' => $status,
                'check_in_time' => $checkIn,
                'check_out_time' => $checkOut,
                'remarks' => $remarks,
                'marked_by' => auth()->id(),
            ]
        );
    }
}
