<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Setting;
use App\Models\Student;
use App\Models\StudentDocument;
use App\Models\StudentNote;
use App\Services\FileStorageService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Student::with(['batches.course', 'admissions.course']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_code', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('batch_id')) {
            $query->whereHas('batches', function ($q) use ($request) {
                $q->where('batches.id', $request->batch_id);
            });
        }

        $students = $query->orderByDesc('id')->paginate(15)->withQueryString();
        $batches = Batch::whereIn('status', ['Upcoming', 'Active'])->get();

        return view('admin.students.index', compact('students', 'batches'));
    }

    public function create(): View
    {
        $courses = Course::where('status', 'active')->orderBy('course_name')->get();
        $batches = Batch::whereIn('status', ['Upcoming', 'Active'])->get();
        return view('admin.students.create', compact('courses', 'batches'));
    }

    public function store(Request $request, FileStorageService $fileStorage): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'id_proof_type' => 'nullable|string|max:50',
            'id_proof_number' => 'nullable|string|max:50',
            'mobile' => 'required|string|max:20|unique:students,mobile',
            'alternate_mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'parent_name' => 'nullable|string|max:100',
            'guardian_name' => 'nullable|string|max:100',
            'parent_mobile' => 'nullable|string|max:20',
            'parent_occupation' => 'nullable|string|max:100',
            'emergency_contact' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:150',
            'passing_year' => 'nullable|string|max:10',
            'previous_experience' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $fileStorage->uploadImage($request->file('photo'), 'uploads/students');
        }

        $prefix = Setting::get('student_id_prefix', 'STU-');
        $year = date('Y');
        $count = Student::whereYear('created_at', $year)->count() + 1;
        $validated['student_code'] = sprintf('%s%s-%04d', $prefix, $year, $count);
        $validated['status'] = 'active';

        $student = Student::create($validated);
        ActivityLog::log('created', 'Student', $student->id, "Student {$student->full_name} ({$student->student_code}) registered");

        return redirect()->route('admin.students.show', $student->id)->with('success', 'Student registered successfully.');
    }

    public function show(int $id): View
    {
        $student = Student::with([
            'admissions.course',
            'admissions.batch',
            'admissions.trainer',
            'admissions.payments',
            'admissions.installments',
            'batches.course',
            'documents',
            'notes.author',
            'attendances.batch',
            'certificates.course',
        ])->findOrFail($id);

        return view('admin.students.show', compact('student'));
    }

    public function edit(int $id): View
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, int $id, FileStorageService $fileStorage): RedirectResponse
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'blood_group' => 'nullable|string|max:10',
            'id_proof_type' => 'nullable|string|max:50',
            'id_proof_number' => 'nullable|string|max:50',
            'mobile' => 'required|string|max:20|unique:students,mobile,' . $student->id,
            'alternate_mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'parent_name' => 'nullable|string|max:100',
            'guardian_name' => 'nullable|string|max:100',
            'parent_mobile' => 'nullable|string|max:20',
            'parent_occupation' => 'nullable|string|max:100',
            'emergency_contact' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:100',
            'institution' => 'nullable|string|max:150',
            'passing_year' => 'nullable|string|max:10',
            'previous_experience' => 'nullable|string|max:500',
            'status' => 'required|string|in:active,completed,dropped,suspended',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $fileStorage->uploadImage($request->file('photo'), 'uploads/students');
        }

        $oldValues = $student->toArray();
        $student->update($validated);
        ActivityLog::log('updated', 'Student', $student->id, "Student {$student->full_name} updated", $oldValues, $student->toArray());

        return redirect()->route('admin.students.show', $student->id)->with('success', 'Student details updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $student = Student::findOrFail($id);
        $student->delete();
        ActivityLog::log('deleted', 'Student', $id, "Student {$student->full_name} ({$student->student_code}) deleted");

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }

    public function uploadDocument(Request $request, int $id, FileStorageService $fileStorage): RedirectResponse
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'document_type' => 'required|string',
            'document_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $uploaded = $fileStorage->uploadDocument($request->file('document_file'), 'uploads/documents');

        StudentDocument::create([
            'student_id' => $student->id,
            'title' => $request->title,
            'document_type' => $request->document_type,
            'file_path' => $uploaded['file_path'],
            'file_name' => $uploaded['file_name'],
            'file_size' => $uploaded['file_size'],
            'mime_type' => $uploaded['mime_type'],
        ]);

        ActivityLog::log('created', 'Document', $student->id, "Document '{$request->title}' uploaded for {$student->full_name}");

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function deleteDocument(int $studentId, int $documentId): RedirectResponse
    {
        $document = StudentDocument::where('student_id', $studentId)->findOrFail($documentId);
        $document->delete();

        return back()->with('success', 'Document removed successfully.');
    }

    public function addNote(Request $request, int $id): RedirectResponse
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        StudentNote::create([
            'student_id' => $student->id,
            'user_id' => auth()->id(),
            'note' => $request->note,
            'is_private' => $request->boolean('is_private'),
        ]);

        return back()->with('success', 'Note added successfully.');
    }
}
