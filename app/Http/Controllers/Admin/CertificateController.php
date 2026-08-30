<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Batch;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Student;
use App\Models\Trainer;
use App\Services\CertificateService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function index(Request $request): View
    {
        $query = Certificate::with(['student', 'course', 'batch', 'trainer']);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('certificate_number', 'like', "%{$search}%")
                  ->orWhere('verification_code', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('student_code', 'like', "%{$search}%");
                  });
            });
        }

        $certificates = $query->orderByDesc('id')->paginate(15)->withQueryString();
        $courses = Course::where('status', 'active')->get();

        return view('admin.certificates.index', compact('certificates', 'courses'));
    }

    public function create(Request $request): View
    {
        $students = Student::where('status', 'active')->orderBy('first_name')->get();
        $courses = Course::where('status', 'active')->get();
        $batches = Batch::all();
        $trainers = Trainer::where('status', 'active')->get();

        return view('admin.certificates.create', compact('students', 'courses', 'batches', 'trainers'));
    }

    public function store(Request $request, CertificateService $certService): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'issue_date' => 'required|date',
            'completion_date' => 'nullable|date',
            'grade' => 'required|string|in:Grade A+,Grade A,Grade B,Distinction,Passed',
            'remarks' => 'nullable|string|max:500',
        ]);

        try {
            $certificate = $certService->generateCertificate($validated);
            return redirect()->route('admin.certificates.show', $certificate->id)->with('success', "Certificate #{$certificate->certificate_number} issued successfully.");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        $certificate = Certificate::with(['student', 'course', 'batch', 'trainer'])->findOrFail($id);
        return view('admin.certificates.show', compact('certificate'));
    }

    public function print(int $id): View
    {
        $certificate = Certificate::with(['student', 'course', 'batch', 'trainer'])->findOrFail($id);
        return view('admin.certificates.print', compact('certificate'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();
        ActivityLog::log('deleted', 'Certificate', $id, "Certificate #{$certificate->certificate_number} deleted");

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
