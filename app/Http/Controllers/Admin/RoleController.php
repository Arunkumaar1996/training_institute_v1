<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::with('permissions')->withCount('users')->get();
        $permissions = Permission::all();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_system' => false,
        ]);

        if (!empty($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        return back()->with('success', 'Role created successfully.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'nullable|string|max:100|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        if (isset($validated['name']) && !$role->is_system) {
            $role->name = $validated['name'];
            $role->slug = Str::slug($validated['name']);
        }

        if (isset($validated['description'])) {
            $role->description = $validated['description'];
        }
        $role->save();

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->input('permissions', []));
        }

        return back()->with('success', 'Role updated successfully.');
    }

    public function updatePermissions(Request $request, int $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->permissions()->sync($request->input('permissions', []));

        return back()->with('success', 'Role permissions updated successfully.');
    }
}
