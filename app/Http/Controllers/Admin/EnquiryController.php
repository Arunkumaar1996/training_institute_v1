<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Enquiry;
use App\Models\FollowUp;
use App\Models\LeadSource;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function index(Request $request): View
    {
        $query = Enquiry::with(['course', 'leadSource', 'assignedUser']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('enquiry_code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $enquiries = $query->orderByDesc('id')->paginate(15)->withQueryString();
        $courses = Course::where('status', 'active')->get();
        $sources = LeadSource::where('status', true)->get();

        $stats = [
            'total' => Enquiry::count(),
            'new' => Enquiry::where('status', 'New')->count(),
            'interested' => Enquiry::where('status', 'Interested')->count(),
            'follow_up' => Enquiry::where('status', 'Follow-up')->count(),
            'converted' => Enquiry::where('status', 'Converted')->count(),
        ];

        return view('admin.enquiries.index', compact('enquiries', 'courses', 'sources', 'stats'));
    }

    public function create(): View
    {
        $courses = Course::where('status', 'active')->get();
        $batches = Batch::whereIn('status', ['Upcoming', 'Active'])->get();
        $sources = LeadSource::where('status', true)->get();
        $users = User::where('status', 'active')->get();

        return view('admin.enquiries.create', compact('courses', 'batches', 'sources', 'users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:150',
            'course_id' => 'nullable|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
            'lead_source_id' => 'nullable|exists:lead_sources,id',
            'assigned_to' => 'nullable|exists:users,id',
            'follow_up_date' => 'nullable|date',
            'status' => 'required|string|in:New,Contacted,Interested,Follow-up,Converted,Not Interested,Closed',
            'message' => 'nullable|string|max:1000',
        ]);

        $year = date('Y');
        $validated['enquiry_code'] = 'ENQ-' . $year . '-' . strtoupper(Str::random(6));

        $enquiry = Enquiry::create($validated);
        ActivityLog::log('created', 'Enquiry', $enquiry->id, "Enquiry #{$enquiry->enquiry_code} created for {$enquiry->name}");

        return redirect()->route('admin.enquiries.show', $enquiry->id)->with('success', 'Enquiry created successfully.');
    }

    public function show(int $id): View
    {
        $enquiry = Enquiry::with(['course', 'batch', 'leadSource', 'assignedUser', 'followUps.user'])->findOrFail($id);
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function addFollowUp(Request $request, int $id): RedirectResponse
    {
        $enquiry = Enquiry::findOrFail($id);

        $notes = $request->input('remarks') ?? $request->input('notes') ?? 'Follow-up logged';
        $status = $request->input('status') ?? ($request->input('response') === 'Positive' ? 'Interested' : 'Follow-up');
        $nextDate = $request->input('next_follow_up') ?? $request->input('next_follow_up_date');
        $nextTime = $request->input('next_follow_up_time');

        FollowUp::create([
            'enquiry_id' => $enquiry->id,
            'user_id' => auth()->id(),
            'follow_up_date' => now()->toDateString(),
            'follow_up_time' => now()->toTimeString(),
            'notes' => $notes,
            'status' => $status,
            'next_follow_up_date' => $nextDate,
            'next_follow_up_time' => $nextTime,
        ]);

        $enquiry->update([
            'status' => $status,
            'follow_up_date' => $nextDate ?? $enquiry->follow_up_date,
        ]);

        ActivityLog::log('updated', 'Enquiry', $enquiry->id, "Follow-up added for Enquiry #{$enquiry->enquiry_code}, status changed to {$status}");

        return back()->with('success', 'Follow-up recorded successfully.');
    }

    public function updateStatus(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $enquiry = Enquiry::findOrFail($id);
        $status = $request->input('status');

        $validStatuses = ['New', 'Contacted', 'Interested', 'Follow-up', 'Demo Scheduled', 'Converted', 'Not Interested', 'Closed', 'Closed / Lost'];
        if ($status && in_array($status, $validStatuses)) {
            $enquiry->status = $status;
            $enquiry->save();
            ActivityLog::log('updated', 'Enquiry', $enquiry->id, "Enquiry #{$enquiry->enquiry_code} status changed to {$status}");
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'status' => $status]);
        }

        return back()->with('success', "Enquiry status updated to {$status}.");
    }

    public function convertToStudent(int $id): RedirectResponse
    {
        $enquiry = Enquiry::findOrFail($id);

        $student = Student::where('mobile', $enquiry->mobile)
            ->orWhere(function ($q) use ($enquiry) {
                if ($enquiry->email) {
                    $q->where('email', $enquiry->email);
                }
            })->first();

        if (!$student) {
            $year = date('Y');
            $studentCode = 'STU-' . $year . '-' . strtoupper(Str::random(5));
            $nameParts = explode(' ', trim($enquiry->name), 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            $student = Student::create([
                'student_code' => $studentCode,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $enquiry->email,
                'mobile' => $enquiry->mobile,
                'status' => 'active',
            ]);
        }

        $enquiry->update([
            'status' => 'Converted',
        ]);

        ActivityLog::log('converted', 'Enquiry', $enquiry->id, "Enquiry #{$enquiry->enquiry_code} converted to Student {$student->student_code}");

        return redirect()->route('admin.students.show', $student->id)->with('success', "Enquiry successfully converted to Student ({$student->student_code}).");
    }

    public function destroy(int $id): RedirectResponse
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->delete();
        ActivityLog::log('deleted', 'Enquiry', $id, "Enquiry #{$enquiry->enquiry_code} deleted");

        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
    }
}
