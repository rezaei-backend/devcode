<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'site_name'        => 'required|string|max:255',
            'meta_description' => 'nullable|string',
            'default_language' => 'required|string|in:fa,en,ar',
            'contact_email'    => 'nullable|email|max:255',
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'favicon'          => 'nullable|mimes:ico,png,svg|max:1024',
            'remove_logo'      => 'nullable|in:1',
            'remove_favicon'   => 'nullable|in:1',
        ]);

        // --- مدیریت لوگو ---
        if ($request->hasFile('logo')) {
            if ($setting->logo_path && Storage::disk('public')->exists('uploads/settings/' . $setting->logo_path)) {
                Storage::disk('public')->delete('uploads/settings/' . $setting->logo_path);
            }
            $logoPath = $request->file('logo')->store('uploads/settings', 'public');
            $validated['logo_path'] = basename($logoPath);
        } elseif ($request->filled('remove_logo')) {
            if ($setting->logo_path && Storage::disk('public')->exists('uploads/settings/' . $setting->logo_path)) {
                Storage::disk('public')->delete('uploads/settings/' . $setting->logo_path);
            }
            $validated['logo_path'] = null;
        }

        // --- مدیریت فاوآیکون ---
        if ($request->hasFile('favicon')) {
            if ($setting->favicon_path && Storage::disk('public')->exists('uploads/settings/' . $setting->favicon_path)) {
                Storage::disk('public')->delete('uploads/settings/' . $setting->favicon_path);
            }
            $faviconPath = $request->file('favicon')->store('uploads/settings', 'public');
            $validated['favicon_path'] = basename($faviconPath);
        } elseif ($request->filled('remove_favicon')) {
            if ($setting->favicon_path && Storage::disk('public')->exists('uploads/settings/' . $setting->favicon_path)) {
                Storage::disk('public')->delete('uploads/settings/' . $setting->favicon_path);
            }
            $validated['favicon_path'] = null;
        }

        // به‌روزرسانی فیلدها
        $setting->update([
            'site_name'        => $validated['site_name'],
            'meta_description' => $validated['meta_description'],
            'default_language' => $validated['default_language'],
            'contact_email'    => $validated['contact_email'],
            'logo_path'        => $validated['logo_path'] ?? $setting->logo_path,
            'favicon_path'     => $validated['favicon_path'] ?? $setting->favicon_path,
        ]);

        return redirect()->route('Settings.index')->with('ok', 'تنظیمات سایت با موفقیت به‌روزرسانی شد.');
    }
}
