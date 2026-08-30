<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSyllabus;
use App\Services\FileStorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::with('category')->withCount(['batches', 'admissions']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('course_name', 'like', "%{$search}%")
                  ->orWhere('course_code', 'like', "%{$search}%");
            });
        }

        $courses = $query->orderBy('sort_order')->paginate(15)->withQueryString();
        $categories = CourseCategory::where('status', true)->get();

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    public function create(): View
    {
        $categories = CourseCategory::where('status', true)->get();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(Request $request, FileStorageService $fileStorage): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:course_categories,id',
            'course_name' => 'required|string|max:150',
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'level' => 'required|string|in:Basic,Intermediate,Advanced,Basic to Advanced',
            'duration' => 'required|integer|min:1',
            'duration_unit' => 'required|string|in:Days,Weeks,Months,Hours',
            'course_fee' => 'required|numeric|min:0',
            'discount_fee' => 'nullable|numeric|min:0',
            'short_description' => 'nullable|string|max:500',
            'full_description' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'requirements' => 'nullable|string',
            'certification_available' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'seo_title' => 'nullable|string|max:150',
            'seo_description' => 'nullable|string|max:300',
            'seo_keywords' => 'nullable|string|max:300',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'brochure_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $validated['slug'] = Str::slug($validated['course_name'] . '-' . Str::random(4));
        $validated['discount_fee'] = $validated['discount_fee'] ?? 0;
        $validated['final_fee'] = max(0, $validated['course_fee'] - $validated['discount_fee']);
        $validated['status'] = 'active';
        $validated['certification_available'] = $request->boolean('certification_available', true);
        $validated['featured'] = $request->boolean('featured');

        if ($request->hasFile('image')) {
            $validated['image'] = $fileStorage->uploadImage($request->file('image'), 'uploads/courses');
        }

        if ($request->hasFile('brochure_file')) {
            $doc = $fileStorage->uploadDocument($request->file('brochure_file'), 'uploads/brochures');
            $validated['brochure_file'] = $doc['file_path'];
        }

        $course = Course::create($validated);
        ActivityLog::log('created', 'Course', $course->id, "Course {$course->course_name} ({$course->course_code}) created");

        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Course created successfully.');
    }

    public function show(int $id): View
    {
        $course = Course::with(['category', 'syllabi', 'batches.trainer', 'admissions.student'])->findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }

    public function edit(int $id): View
    {
        $course = Course::findOrFail($id);
        $categories = CourseCategory::where('status', true)->get();
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, int $id, FileStorageService $fileStorage): RedirectResponse
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'nullable|exists:course_categories,id',
            'course_name' => 'required|string|max:150',
            'course_code' => 'required|string|max:50|unique:courses,course_code,' . $course->id,
            'level' => 'required|string|in:Basic,Intermediate,Advanced,Basic to Advanced',
            'duration' => 'required|integer|min:1',
            'duration_unit' => 'required|string|in:Days,Weeks,Months,Hours',
            'course_fee' => 'required|numeric|min:0',
            'discount_fee' => 'nullable|numeric|min:0',
            'short_description' => 'nullable|string|max:500',
            'full_description' => 'nullable|string',
            'learning_outcomes' => 'nullable|string',
            'requirements' => 'nullable|string',
            'certification_available' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'status' => 'required|string|in:active,inactive',
            'seo_title' => 'nullable|string|max:150',
            'seo_description' => 'nullable|string|max:300',
            'seo_keywords' => 'nullable|string|max:300',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'brochure_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $validated['discount_fee'] = $validated['discount_fee'] ?? 0;
        $validated['final_fee'] = max(0, $validated['course_fee'] - $validated['discount_fee']);
        $validated['certification_available'] = $request->boolean('certification_available');
        $validated['featured'] = $request->boolean('featured');

        if ($request->hasFile('image')) {
            $validated['image'] = $fileStorage->uploadImage($request->file('image'), 'uploads/courses');
        }

        if ($request->hasFile('brochure_file')) {
            $doc = $fileStorage->uploadDocument($request->file('brochure_file'), 'uploads/brochures');
            $validated['brochure_file'] = $doc['file_path'];
        }

        $course->update($validated);
        ActivityLog::log('updated', 'Course', $course->id, "Course {$course->course_name} updated");

        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Course updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $course->delete();
        ActivityLog::log('deleted', 'Course', $id, "Course {$course->course_name} deleted");

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }

    public function toggleFeatured(int $id): JsonResponse
    {
        $course = Course::findOrFail($id);
        $course->featured = !$course->featured;
        $course->save();

        return response()->json(['success' => true, 'featured' => $course->featured]);
    }

    public function toggleStatus(int $id): JsonResponse
    {
        $course = Course::findOrFail($id);
        $course->status = ($course->status === 'active') ? 'inactive' : 'active';
        $course->save();

        return response()->json(['success' => true, 'status' => $course->status]);
    }

    public function storeSyllabus(Request $request, int $courseId): RedirectResponse
    {
        $course = Course::findOrFail($courseId);
        $validated = $request->validate([
            'module_number' => 'required|integer|min:1',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'topics' => 'nullable|string',
            'duration_hours' => 'nullable|integer',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['course_id'] = $course->id;
        CourseSyllabus::create($validated);

        return back()->with('success', 'Syllabus module added successfully.');
    }

    public function deleteSyllabus(int $courseId, int $syllabusId): RedirectResponse
    {
        $syllabus = CourseSyllabus::where('course_id', $courseId)->findOrFail($syllabusId);
        $syllabus->delete();

        return back()->with('success', 'Syllabus module removed.');
    }
}
