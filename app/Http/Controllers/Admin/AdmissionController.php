<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Admission;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Student;
use App\Models\Trainer;
use App\Services\AdmissionFeeService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Admission::with(['student', 'course', 'batch', 'trainer', 'payments']);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('admission_status')) {
            $query->where('admission_status', $request->admission_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('admission_number', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('student_code', 'like', "%{$search}%")
                         ->orWhere('mobile', 'like', "%{$search}%");
                  });
            });
        }

        $admissions = $query->orderByDesc('id')->paginate(15)->withQueryString();
        $courses = Course::where('status', 'active')->get();

        return view('admin.admissions.index', compact('admissions', 'courses'));
    }

    public function create(Request $request): View
    {
        $selectedStudentId = $request->query('student_id');
        $students = Student::where('status', 'active')->orderBy('first_name')->get();
        $courses = Course::where('status', 'active')->orderBy('course_name')->get();
        $batches = Batch::whereIn('status', ['Upcoming', 'Active'])->get();
        $trainers = Trainer::where('status', 'active')->get();

        return view('admin.admissions.create', compact('students', 'courses', 'batches', 'trainers', 'selectedStudentId'));
    }

    public function store(Request $request, AdmissionFeeService $admissionService): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
            'trainer_id' => 'nullable|exists:trainers,id',
            'admission_date' => 'required|date',
            'course_fee' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date',
            'initial_payment' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|in:Cash,UPI,Bank Transfer,Card,Cheque,Online,Other',
            'transaction_number' => 'nullable|string|max:100',
            'source' => 'nullable|string|max:50',
            'referral_by' => 'nullable|string|max:100',
            'remarks' => 'nullable|string|max:500',
            'installments' => 'nullable|array',
            'installments.*.title' => 'nullable|string',
            'installments.*.due_date' => 'nullable|date',
            'installments.*.amount' => 'nullable|numeric|min:0',
        ]);

        try {
            $admission = $admissionService->createAdmission($validated);
            return redirect()->route('admin.admissions.show', $admission->id)->with('success', "Admission #{$admission->admission_number} created successfully.");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        $admission = Admission::with([
            'student',
            'course',
            'batch',
            'trainer',
            'payments.collector',
            'installments.payments',
        ])->findOrFail($id);

        return view('admin.admissions.show', compact('admission'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $admission = Admission::findOrFail($id);
        $admission->delete();
        ActivityLog::log('deleted', 'Admission', $id, "Admission #{$admission->admission_number} deleted");

        return redirect()->route('admin.admissions.index')->with('success', 'Admission record deleted.');
    }
}
