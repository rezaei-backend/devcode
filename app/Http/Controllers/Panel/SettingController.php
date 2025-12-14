<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $setting = Setting::first();
        return view('panel.settings.index', compact('setting'));
    }

    public function edit()
    {
        $setting = Setting::first();
        return view('panel.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $uploadPath = public_path('images/settings');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $setting = Setting::firstOrCreate(['id' => 1]);

        $request->merge([
            'remove_logo'    => $request->has('remove_logo') ? 1 : 0,
            'remove_favicon' => $request->has('remove_favicon') ? 1 : 0,
        ]);

        $validated = $request->validate([
            'site_name'        => 'required|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'default_language' => 'required|in:fa,en,ar',
            'contact_email'    => 'nullable|email|max:255',
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'favicon'          => 'nullable|mimes:ico,png,svg,webp|max:1024',
            'remove_logo'      => 'in:0,1',
            'remove_favicon'   => 'in:0,1',
        ]);

        $logoPath = $setting->logo_path;
        $faviconPath = $setting->favicon_path;

        if ($validated['remove_logo'] == 1) {
            if ($logoPath && File::exists("{$uploadPath}/{$logoPath}")) File::delete("{$uploadPath}/{$logoPath}");
            $logoPath = null;
        } elseif ($request->hasFile('logo')) {
            if ($logoPath && File::exists("{$uploadPath}/{$logoPath}")) File::delete("{$uploadPath}/{$logoPath}");
            $fileName = 'logo_' . time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->move($uploadPath, $fileName);
            $logoPath = $fileName;
        }

        if ($validated['remove_favicon'] == 1) {
            if ($faviconPath && File::exists("{$uploadPath}/{$faviconPath}")) File::delete("{$uploadPath}/{$faviconPath}");
            $faviconPath = null;
        } elseif ($request->hasFile('favicon')) {
            if ($faviconPath && File::exists("{$uploadPath}/{$faviconPath}")) File::delete("{$uploadPath}/{$faviconPath}");
            $fileName = 'favicon_' . time() . '.' . $request->file('favicon')->getClientOriginalExtension();
            $request->file('favicon')->move($uploadPath, $fileName);
            $faviconPath = $fileName;
        }

        $setting->update([
            'site_name'        => $validated['site_name'],
            'meta_description' => $validated['meta_description'],
            'default_language' => $validated['default_language'],
            'contact_email'    => $validated['contact_email'],
            'logo_path'        => $logoPath,
            'favicon_path'     => $faviconPath,
        ]);

        $this->logActivity('updated', $setting);

        return redirect()->route('settings.index')->with('success', 'تنظیمات با موفقیت ذخیره شد.');
    }
}
