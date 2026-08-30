<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Enquiry;
use App\Models\FollowUp;
use App\Models\LeadSource;
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

        $validated = $request->validate([
            'notes' => 'required|string',
            'status' => 'required|string|in:New,Contacted,Interested,Follow-up,Converted,Not Interested,Closed',
            'next_follow_up_date' => 'nullable|date',
            'next_follow_up_time' => 'nullable',
        ]);

        FollowUp::create([
            'enquiry_id' => $enquiry->id,
            'user_id' => auth()->id(),
            'follow_up_date' => now()->toDateString(),
            'follow_up_time' => now()->toTimeString(),
            'notes' => $validated['notes'],
            'status' => $validated['status'],
            'next_follow_up_date' => $validated['next_follow_up_date'] ?? null,
            'next_follow_up_time' => $validated['next_follow_up_time'] ?? null,
        ]);

        $enquiry->update([
            'status' => $validated['status'],
            'follow_up_date' => $validated['next_follow_up_date'] ?? $enquiry->follow_up_date,
        ]);

        ActivityLog::log('updated', 'Enquiry', $enquiry->id, "Follow-up added for Enquiry #{$enquiry->enquiry_code}, status changed to {$validated['status']}");

        return back()->with('success', 'Follow-up recorded successfully.');
    }

    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $enquiry = Enquiry::findOrFail($id);
        $status = $request->input('status');

        $validStatuses = ['New', 'Contacted', 'Interested', 'Follow-up', 'Converted', 'Not Interested', 'Closed'];
        if (!in_array($status, $validStatuses)) {
            return response()->json(['success' => false, 'message' => 'Invalid status.'], 422);
        }

        $enquiry->status = $status;
        $enquiry->save();

        ActivityLog::log('updated', 'Enquiry', $enquiry->id, "Enquiry #{$enquiry->enquiry_code} status changed to {$status}");

        return response()->json(['success' => true, 'status' => $status]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->delete();
        ActivityLog::log('deleted', 'Enquiry', $id, "Enquiry #{$enquiry->enquiry_code} deleted");

        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted.');
    }
}
