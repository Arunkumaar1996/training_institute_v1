<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\CourseCategory;
use App\Services\FileStorageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseCategoryController extends Controller
{
    public function index(): View
    {
        $categories = CourseCategory::withCount('courses')->orderBy('sort_order')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request, FileStorageService $fileStorage): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:course_categories,name',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $fileStorage->uploadImage($request->file('image'), 'uploads/categories');
        }

        $category = CourseCategory::create($validated);
        ActivityLog::log('created', 'Category', $category->id, "Course Category '{$category->name}' created");

        return back()->with('success', 'Course Category created successfully.');
    }

    public function update(Request $request, int $id, FileStorageService $fileStorage): RedirectResponse
    {
        $category = CourseCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:course_categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            $validated['image'] = $fileStorage->uploadImage($request->file('image'), 'uploads/categories');
        }

        $category->update($validated);
        ActivityLog::log('updated', 'Category', $category->id, "Course Category '{$category->name}' updated");

        return back()->with('success', 'Course Category updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $category = CourseCategory::withCount('courses')->findOrFail($id);
        if ($category->courses_count > 0) {
            return back()->with('error', 'Cannot delete category that contains active courses.');
        }

        $category->delete();
        ActivityLog::log('deleted', 'Category', $id, "Course Category '{$category->name}' deleted");

        return back()->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus(int $id): JsonResponse
    {
        $category = CourseCategory::findOrFail($id);
        $category->status = !$category->status;
        $category->save();

        return response()->json([
            'success' => true,
            'status' => $category->status,
            'message' => 'Status updated successfully.',
        ]);
    }
}
