<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Student;
use App\Models\Trainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BatchController extends Controller
{
    public function index(Request $request): View
    {
        $query = Batch::with(['course', 'trainer'])->withCount('students');

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('trainer_id')) {
            $query->where('trainer_id', $request->trainer_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $batches = $query->orderByDesc('start_date')->paginate(15)->withQueryString();
        $courses = Course::where('status', 'active')->get();
        $trainers = Trainer::where('status', 'active')->get();

        return view('admin.batches.index', compact('batches', 'courses', 'trainers'));
    }

    public function create(): View
    {
        $courses = Course::where('status', 'active')->get();
        $trainers = Trainer::where('status', 'active')->get();
        return view('admin.batches.create', compact('courses', 'trainers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'batch_name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'days_schedule' => 'nullable|string|max:100',
            'max_students' => 'required|integer|min:1|max:200',
            'room_number' => 'nullable|string|max:50',
            'mode' => 'required|string|in:Offline,Online,Hybrid',
            'status' => 'required|string|in:Upcoming,Active,Completed,Cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $course = Course::find($validated['course_id']);
        $year = date('y');
        $count = Batch::whereYear('created_at', date('Y'))->count() + 1;
        $validated['batch_code'] = sprintf('BAT-%s%s-%03d', strtoupper(substr($course->course_code ?? 'CRS', 0, 3)), $year, $count);

        $batch = Batch::create($validated);

        if (!empty($validated['trainer_id'])) {
            $batch->trainers()->syncWithoutDetaching([$validated['trainer_id'] => ['is_primary' => true]]);
        }

        ActivityLog::log('created', 'Batch', $batch->id, "Batch {$batch->batch_name} ({$batch->batch_code}) created");

        return redirect()->route('admin.batches.show', $batch->id)->with('success', 'Batch created successfully.');
    }

    public function show(int $id): View
    {
        $batch = Batch::with(['course', 'trainer', 'students', 'attendances.student'])->findOrFail($id);
        $enrolledIds = $batch->students->pluck('id')->toArray();
        $availableStudents = Student::where('status', 'active')->whereNotIn('id', $enrolledIds)->orderBy('first_name')->get();

        return view('admin.batches.show', compact('batch', 'availableStudents'));
    }

    public function edit(int $id): View
    {
        $batch = Batch::findOrFail($id);
        $courses = Course::where('status', 'active')->get();
        $trainers = Trainer::where('status', 'active')->get();

        return view('admin.batches.edit', compact('batch', 'courses', 'trainers'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $batch = Batch::findOrFail($id);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'batch_name' => 'required|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'days_schedule' => 'nullable|string|max:100',
            'max_students' => 'required|integer|min:1|max:200',
            'room_number' => 'nullable|string|max:50',
            'mode' => 'required|string|in:Offline,Online,Hybrid',
            'status' => 'required|string|in:Upcoming,Active,Completed,Cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $batch->update($validated);

        if (!empty($validated['trainer_id'])) {
            $batch->trainers()->syncWithoutDetaching([$validated['trainer_id'] => ['is_primary' => true]]);
        }

        ActivityLog::log('updated', 'Batch', $batch->id, "Batch {$batch->batch_name} updated");

        return redirect()->route('admin.batches.show', $batch->id)->with('success', 'Batch updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $batch = Batch::findOrFail($id);
        $batch->delete();
        ActivityLog::log('deleted', 'Batch', $id, "Batch {$batch->batch_name} deleted");

        return redirect()->route('admin.batches.index')->with('success', 'Batch deleted successfully.');
    }

    public function assignStudents(Request $request, int $id): RedirectResponse
    {
        $batch = Batch::findOrFail($id);
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $currentCount = $batch->students()->count();
        $toAddCount = count($request->student_ids);

        // Business rule: Check batch capacity
        if (($currentCount + $toAddCount) > $batch->max_students) {
            return back()->with('error', "Cannot assign {$toAddCount} student(s). Batch capacity limit of {$batch->max_students} would be exceeded.");
        }

        $syncData = [];
        foreach ($request->student_ids as $stuId) {
            $syncData[$stuId] = [
                'assigned_date' => now()->toDateString(),
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $batch->students()->syncWithoutDetaching($syncData);
        ActivityLog::log('updated', 'Batch', $batch->id, "{$toAddCount} students assigned to Batch {$batch->batch_code}");

        return back()->with('success', "{$toAddCount} student(s) assigned to batch successfully.");
    }

    public function removeStudent(int $batchId, int $studentId): RedirectResponse
    {
        $batch = Batch::findOrFail($batchId);
        $batch->students()->detach($studentId);
        ActivityLog::log('updated', 'Batch', $batch->id, "Student #{$studentId} removed from Batch {$batch->batch_code}");

        return back()->with('success', 'Student removed from batch.');
    }
}
