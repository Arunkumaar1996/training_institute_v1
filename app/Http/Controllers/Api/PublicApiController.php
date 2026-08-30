<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Enquiry;
use App\Models\LeadSource;
use App\Models\Student;
use App\Services\CertificateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicApiController extends Controller
{
    public function courses(): JsonResponse
    {
        $courses = Course::with('category')->where('status', 'active')->orderBy('sort_order')->get();
        return response()->json(['success' => true, 'data' => $courses]);
    }

    public function courseDetail(string $slug): JsonResponse
    {
        $course = Course::with(['category', 'syllabi', 'batches' => function ($q) {
            $q->whereIn('status', ['Upcoming', 'Active']);
        }])->where('slug', $slug)->firstOrFail();

        return response()->json(['success' => true, 'data' => $course]);
    }

    public function batches(): JsonResponse
    {
        $batches = Batch::with(['course', 'trainer'])->whereIn('status', ['Upcoming', 'Active'])->get();
        return response()->json(['success' => true, 'data' => $batches]);
    }

    public function submitEnquiry(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email',
            'course_id' => 'nullable|exists:courses,id',
            'message' => 'nullable|string|max:1000',
        ]);

        $webSource = LeadSource::firstOrCreate(
            ['slug' => 'api'],
            ['name' => 'API / Mobile App', 'status' => true]
        );

        $enquiry = Enquiry::create([
            'enquiry_code' => 'ENQ-' . date('Y') . '-' . strtoupper(Str::random(6)),
            'name' => $validated['name'],
            'mobile' => $validated['mobile'],
            'email' => $validated['email'] ?? null,
            'course_id' => $validated['course_id'] ?? null,
            'lead_source_id' => $webSource->id,
            'message' => $validated['message'] ?? 'Enquiry from Mobile API',
            'status' => 'New',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Enquiry submitted successfully',
            'data' => ['enquiry_code' => $enquiry->enquiry_code],
        ], 201);
    }

    public function verifyCertificate(string $code, CertificateService $certService): JsonResponse
    {
        $certificate = $certService->verify($code);

        if (!$certificate) {
            return response()->json(['success' => false, 'message' => 'Certificate not found or invalid.'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'is_valid' => ($certificate->status === 'Issued'),
                'certificate_number' => $certificate->certificate_number,
                'student_name' => $certificate->student?->full_name,
                'course_name' => $certificate->course?->course_name,
                'issue_date' => $certificate->issue_date->format('d M Y'),
                'grade' => $certificate->grade,
                'status' => $certificate->status,
            ],
        ]);
    }

    public function students(): JsonResponse
    {
        $students = Student::with('batches.course')->paginate(20);
        return response()->json(['success' => true, 'data' => $students]);
    }
}
