<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::withCount('employees')->with('designations')->get();
        $designations = Designation::with('department')->withCount('employees')->get();

        return view('admin.departments.index', compact('departments', 'designations'));
    }

    public function storeDepartment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:departments,name',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['status'] = true;
        Department::create($validated);

        return back()->with('success', 'Department created successfully.');
    }

    public function storeDesignation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['status'] = true;
        Designation::create($validated);

        return back()->with('success', 'Designation created successfully.');
    }
}
