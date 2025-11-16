<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $setting = SiteSetting::firstOrCreate([]);
        return view('panel.settings.index', compact('setting'));
    }

    public function edit()
    {
        $setting = SiteSetting::firstOrFail();
        return view('panel.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = SiteSetting::firstOrFail();

        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'meta_description' => 'nullable|string',
            'default_language' => 'required|string|in:fa,en,ar',
            'contact_email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'favicon' => 'nullable|mimes:ico,png,svg|max:1024',
            'remove_logo' => 'nullable|in:1',
            'remove_favicon' => 'nullable|in:1',
        ]);

        $logoPath = $setting->logo_path;
        $faviconPath = $setting->favicon_path;

        // --- مدیریت لوگو ---
        if ($request->hasFile('logo')) {
            if ($setting->logo_path && File::exists(public_path('images/settings/' . $setting->logo_path))) {
                File::delete(public_path('images/settings/' . $setting->logo_path));
            }
            $fileName = time() . '_logo_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('images/settings'), $fileName);
            $logoPath = $fileName;
        } elseif ($request->filled('remove_logo') && $setting->logo_path) {
            if (File::exists(public_path('images/settings/' . $setting->logo_path))) {
                File::delete(public_path('images/settings/' . $setting->logo_path));
            }
            $logoPath = null;
        }

        // --- مدیریت فاوآیکون ---
        if ($request->hasFile('favicon')) {
            if ($setting->favicon_path && File::exists(public_path('images/settings/' . $setting->favicon_path))) {
                File::delete(public_path('images/settings/' . $setting->favicon_path));
            }
            $fileName = time() . '_favicon_' . $request->file('favicon')->getClientOriginalName();
            $request->file('favicon')->move(public_path('images/settings'), $fileName);
            $faviconPath = $fileName;
        } elseif ($request->filled('remove_favicon') && $setting->favicon_path) {
            if (File::exists(public_path('images/settings/' . $setting->favicon_path))) {
                File::delete(public_path('images/settings/' . $setting->favicon_path));
            }
            $faviconPath = null;
        }

        // به‌روزرسانی فیلدها
        $setting->update([
            'site_name' => $validated['site_name'],
            'meta_description' => $validated['meta_description'],
            'default_language' => $validated['default_language'],
            'contact_email' => $validated['contact_email'],
            'logo_path' => $logoPath,
            'favicon_path' => $faviconPath,
        ]);

        return redirect()->route('Settings.index')->with('ok', 'تنظیمات سایت با موفقیت به‌روزرسانی شد.');
    }
}
