<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class SettingController extends Controller
{

    public function index()
    {
        $settings = Setting::first();
        return view('panel.settings.index', compact('setting'));
    }


    public function edit()
    {
        $setting = SiteSetting::firstOrFail();
        return view('panel.settings.edit', compact('setting', 'users'));
    }

    /**
     * Update the site settings in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'logo_path' => 'nullable|string|max:255',
            'favicon_path' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'default_language' => 'required|string|max:10',
            'contact_email' => 'nullable|email|max:255',
        ]);

        $setting = SiteSetting::firstOrFail();
        $setting->update([
            'site_name' => $validated['site_name'],
            'logo_path' => $validated['logo_path'],
            'favicon_path' => $validated['favicon_path'],
            'meta_description' => $validated['meta_description'],
            'default_language' => $validated['default_language'],
            'contact_email' => $validated['contact_email'],
        ]);

        return redirect()->route('Settings.index')->with('ok', 'تنظیمات سایت با موفقیت به‌روزرسانی شد.');
    }
}
