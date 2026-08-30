<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Services\AttendanceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function studentAttendance(Request $request): View
    {
        $batchId = $request->query('batch_id');
        $date = $request->query('date', now()->toDateString());

        $batches = Batch::with('course')->whereIn('status', ['Upcoming', 'Active'])->get();
        $selectedBatch = $batchId ? Batch::with('students')->find($batchId) : null;
        $attendances = [];

        if ($selectedBatch) {
            $existing = StudentAttendance::where('batch_id', $batchId)
                ->where('attendance_date', $date)
                ->get()
                ->keyBy('student_id');

            foreach ($selectedBatch->students as $student) {
                $attendances[$student->id] = $existing->get($student->id)?->status ?? 'Present';
            }
        }

        return view('admin.attendance.students', compact('batches', 'selectedBatch', 'date', 'attendances'));
    }

    public function saveStudentAttendance(Request $request, AttendanceService $attendanceService): JsonResponse
    {
        $validated = $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'attendance_date' => 'required|date',
            'records' => 'required|array',
        ]);

        try {
            $count = $attendanceService->saveBatchAttendance(
                $validated['batch_id'],
                $validated['attendance_date'],
                $validated['records'],
                auth()->id()
            );

            return response()->json([
                'success' => true,
                'message' => "Attendance saved for {$count} student(s) successfully.",
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function employeeAttendance(Request $request): View
    {
        $date = $request->query('date', now()->toDateString());
        $employees = Employee::with(['department', 'designation'])->where('status', 'active')->get();
        $existing = EmployeeAttendance::where('attendance_date', $date)->get()->keyBy('employee_id');

        return view('admin.attendance.employees', compact('employees', 'existing', 'date'));
    }

    public function saveEmployeeAttendance(Request $request, AttendanceService $attendanceService): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'status' => 'required|string|in:Present,Absent,Half Day,Leave,Holiday,Late',
            'check_in_time' => 'nullable',
            'check_out_time' => 'nullable',
            'remarks' => 'nullable|string|max:200',
        ]);

        $attendanceService->saveEmployeeAttendance(
            $validated['employee_id'],
            $validated['attendance_date'],
            $validated['status'],
            $validated['check_in_time'] ?? null,
            $validated['check_out_time'] ?? null,
            $validated['remarks'] ?? null
        );

        return back()->with('success', 'Employee attendance updated successfully.');
    }

    public function reports(Request $request): View
    {
        $batchId = $request->query('batch_id');
        $batches = Batch::with('course')->get();
        $students = [];

        if ($batchId) {
            $batch = Batch::with('students')->findOrFail($batchId);
            $totalDays = StudentAttendance::where('batch_id', $batchId)->distinct('attendance_date')->count('attendance_date');

            foreach ($batch->students as $student) {
                $presentCount = StudentAttendance::where('batch_id', $batchId)
                    ->where('student_id', $student->id)
                    ->whereIn('status', ['Present', 'Late'])
                    ->count();

                $percentage = $totalDays > 0 ? round(($presentCount / $totalDays) * 100, 1) : 0;

                $students[] = [
                    'student' => $student,
                    'total_days' => $totalDays,
                    'present_days' => $presentCount,
                    'percentage' => $percentage,
                ];
            }
        }

        return view('admin.attendance.reports', compact('batches', 'batchId', 'students'));
    }
}
