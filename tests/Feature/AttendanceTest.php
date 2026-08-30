<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Batch;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Services\AttendanceService;

class AttendanceTest extends TestCase
{
    public function test_batch_attendance_marking_and_uniqueness(): void
    {
        $batch = Batch::first();
        $students = $batch->students;

        $service = app(AttendanceService::class);
        $date = now()->toDateString();

        $records = [];
        foreach ($students as $stu) {
            $records[$stu->id] = [
                'status' => 'Present',
                'remarks' => 'Lab On-time',
            ];
        }

        $count = $service->saveBatchAttendance($batch->id, $date, $records);
        $this->assertGreaterThan(0, $count);

        foreach ($students as $stu) {
            $this->assertDatabaseHas('student_attendances', [
                'student_id' => $stu->id,
                'batch_id' => $batch->id,
                'attendance_date' => $date,
                'status' => 'Present',
            ]);
        }
    }
}
