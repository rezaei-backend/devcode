<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;

class LanguageController extends Controller
{
    // نمایش لیست زبان‌ها
    public function index()
    {
        $languages = Language::all();
        return view('panel.language.index', compact('languages'));
    }

    // صفحه افزودن زبان
    public function create()
    {
        return view('panel.language.create');
    }

    // ذخیره زبان جدید
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
        ]);

        $data = $request->all();
        $destinationPath = public_path('Panel/pictures/language/');

        if ($request->hasFile('logo')) {
            $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move($destinationPath, $fileName);
            $data['logo'] = $fileName;
        }

        Language::create($data);

        return redirect()->route('language.index')->with('success', 'زبان با موفقیت اضافه شد.');
    }

    // نمایش فرم ویرایش
    public function edit($slug)
    {
        $language = Language::where('slug', $slug)->firstOrFail();
        return view('panel.language.edit', compact('language'));
    }

    // بروزرسانی زبان
    public function update(Request $request, string $id)
    {
        $language = Language::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
        ]);

        $data = $request->all();
        $language->update($data);

        return redirect()->route('language.index')->with('success', 'زبان با موفقیت ویرایش شد.');
    }

    // حذف زبان
    public function destroy(string $id)
    {
        $language = Language::findOrFail($id);

        $destinationPath = public_path('Panel/pictures/language/');

        if ($language->logo && File::exists($destinationPath . $language->logo)) {
            File::delete($destinationPath . $language->logo);
        }

        $language->delete();

        return redirect()->route('language.index')->with('success', 'زبان با موفقیت حذف شد.');
    }
}
