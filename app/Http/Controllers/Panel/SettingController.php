<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SettingController extends Controller
{
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

        $validated = $request->validate([
            'site_name'          => 'required|string|max:255',
            'meta_description'   => 'nullable|string|max:500',
            'default_language'   => 'required|in:fa,en,ar',
            'contact_email'      => 'nullable|email|max:255',
            'logo'               => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'favicon'            => 'nullable|mimes:ico,png,svg,webp|max:1024',
            'remove_logo'        => 'nullable|in:1',
            'remove_favicon'     => 'nullable|in:1',
        ]);

        $logoPath = $setting->logo_path;
        $faviconPath = $setting->favicon_path;

        if ($request->hasFile('logo')) {
            if ($logoPath && File::exists($uploadPath . '/' . $logoPath)) {
                File::delete($uploadPath . '/' . $logoPath);
            }

            $file = $request->file('logo');
            $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $fileName);
            $logoPath = $fileName;

        } elseif ($request->has('remove_logo')) {
            if ($logoPath && File::exists($uploadPath . '/' . $logoPath)) {
                File::delete($uploadPath . '/' . $logoPath);
            }
            $logoPath = null;
        }

        if ($request->hasFile('favicon')) {
            if ($faviconPath && File::exists($uploadPath . '/' . $faviconPath)) {
                File::delete($uploadPath . '/' . $faviconPath);
            }

            $file = $request->file('favicon');
            $fileName = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $fileName);
            $faviconPath = $fileName;

        } elseif ($request->has('remove_favicon')) {
            if ($faviconPath && File::exists($uploadPath . '/' . $faviconPath)) {
                File::delete($uploadPath . '/' . $faviconPath);
            }
            $faviconPath = null;
        }

        $setting->update([
            'site_name'         => $validated['site_name'],
            'meta_description'  => $validated['meta_description'],
            'default_language'  => $validated['default_language'],
            'contact_email'     => $validated['contact_email'],
            'logo_path'         => $logoPath,
            'favicon_path'      => $faviconPath,
        ]);

        return redirect()
            ->route('settings.index')
            ->with('success', 'تنظیمات سایت با موفقیت ذخیره شد.');
    }
}
