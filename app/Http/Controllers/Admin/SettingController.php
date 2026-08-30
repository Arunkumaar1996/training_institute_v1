<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Services\FileStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request, FileStorageService $fileStorage): RedirectResponse
    {
        $inputs = $request->except(['_token', '_method', 'logo', 'favicon']);

        foreach ($inputs as $key => $value) {
            Setting::set($key, $value);
        }

        if ($request->hasFile('logo')) {
            $logoPath = $fileStorage->uploadImage($request->file('logo'), 'uploads/settings');
            Setting::set('institute_logo', $logoPath);
        }

        if ($request->hasFile('favicon')) {
            $favPath = $fileStorage->uploadImage($request->file('favicon'), 'uploads/settings');
            Setting::set('institute_favicon', $favPath);
        }

        ActivityLog::log('updated', 'Setting', null, 'Master system settings updated');

        return back()->with('success', 'Settings updated successfully.');
    }
}
