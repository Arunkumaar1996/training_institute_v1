<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Trainer;
use App\Services\FileStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainerController extends Controller
{
    public function index(): View
    {
        $trainers = Trainer::withCount(['batches', 'admissions'])->orderByDesc('id')->paginate(15);
        return view('admin.trainers.index', compact('trainers'));
    }

    public function create(): View
    {
        return view('admin.trainers.create');
    }

    public function store(Request $request, FileStorageService $fileStorage): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:trainers,email',
            'mobile' => 'required|string|max:20',
            'alternate_mobile' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:100',
            'experience_years' => 'nullable|integer|min:0',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'skills' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $fileStorage->uploadImage($request->file('photo'), 'uploads/trainers');
        }

        $year = date('y');
        $count = Trainer::count() + 1;
        $validated['trainer_code'] = sprintf('TRN-%s-%03d', $year, $count);
        $validated['status'] = 'active';

        $trainer = Trainer::create($validated);
        ActivityLog::log('created', 'Trainer', $trainer->id, "Trainer {$trainer->name} ({$trainer->trainer_code}) added");

        return redirect()->route('admin.trainers.show', $trainer->id)->with('success', 'Trainer added successfully.');
    }

    public function show(int $id): View
    {
        $trainer = Trainer::with(['batches.course', 'batches.students', 'admissions.student'])->findOrFail($id);
        return view('admin.trainers.show', compact('trainer'));
    }

    public function edit(int $id): View
    {
        $trainer = Trainer::findOrFail($id);
        return view('admin.trainers.edit', compact('trainer'));
    }

    public function update(Request $request, int $id, FileStorageService $fileStorage): RedirectResponse
    {
        $trainer = Trainer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:trainers,email,' . $trainer->id,
            'mobile' => 'required|string|max:20',
            'alternate_mobile' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:100',
            'experience_years' => 'nullable|integer|min:0',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'skills' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'status' => 'required|string|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $fileStorage->uploadImage($request->file('photo'), 'uploads/trainers');
        }

        $trainer->update($validated);
        ActivityLog::log('updated', 'Trainer', $trainer->id, "Trainer {$trainer->name} updated");

        return redirect()->route('admin.trainers.show', $trainer->id)->with('success', 'Trainer details updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $trainer = Trainer::findOrFail($id);
        $trainer->delete();
        ActivityLog::log('deleted', 'Trainer', $id, "Trainer {$trainer->name} deleted");

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer record removed.');
    }
}
