<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Services\FileStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Employee::with(['department', 'designation']);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $employees = $query->orderByDesc('id')->paginate(15)->withQueryString();
        $departments = Department::where('status', true)->get();

        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function create(): View
    {
        $departments = Department::where('status', true)->get();
        $designations = Designation::where('status', true)->get();
        return view('admin.employees.create', compact('departments', 'designations'));
    }

    public function store(Request $request, FileStorageService $fileStorage): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:150|unique:employees,email',
            'mobile' => 'required|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'qualification' => 'nullable|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'employment_type' => 'required|string|in:Full-Time,Part-Time,Contract',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $fileStorage->uploadImage($request->file('photo'), 'uploads/employees');
        }

        $year = date('y');
        $count = Employee::count() + 1;
        $validated['employee_code'] = sprintf('EMP-%s-%03d', $year, $count);
        $validated['status'] = 'active';

        $employee = Employee::create($validated);
        ActivityLog::log('created', 'Employee', $employee->id, "Employee {$employee->full_name} ({$employee->employee_code}) created");

        return redirect()->route('admin.employees.show', $employee->id)->with('success', 'Employee registered successfully.');
    }

    public function show(int $id): View
    {
        $employee = Employee::with(['department', 'designation', 'attendances'])->findOrFail($id);
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(int $id): View
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::where('status', true)->get();
        $designations = Designation::where('status', true)->get();

        return view('admin.employees.edit', compact('employee', 'departments', 'designations'));
    }

    public function update(Request $request, int $id, FileStorageService $fileStorage): RedirectResponse
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:150|unique:employees,email,' . $employee->id,
            'mobile' => 'required|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'qualification' => 'nullable|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'employment_type' => 'required|string|in:Full-Time,Part-Time,Contract',
            'status' => 'required|string|in:active,inactive,terminated,on-leave',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $fileStorage->uploadImage($request->file('photo'), 'uploads/employees');
        }

        $employee->update($validated);
        ActivityLog::log('updated', 'Employee', $employee->id, "Employee {$employee->full_name} updated");

        return redirect()->route('admin.employees.show', $employee->id)->with('success', 'Employee updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        ActivityLog::log('deleted', 'Employee', $id, "Employee {$employee->full_name} deleted");

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted.');
    }
}
