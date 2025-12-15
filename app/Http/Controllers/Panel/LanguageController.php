<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

class LanguageController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $languages = Language::all();
        return view('panel.language.index', compact('languages'));
    }

    public function create()
    {
        return view('panel.language.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'description'      => 'required|string|max:255',
            'logo'             => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_color'    => 'required|string',
            'secondary_color'  => 'required|string',
        ]);

        $data = $request->all();
//        dd($data);
        $destinationPath = public_path('images/language/');

        if ($request->hasFile('logo')) {
            $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move($destinationPath, $fileName);
            $data['logo'] = $fileName;
        }

        $language = Language::create($data);

        $this->logActivity('created', $language);

        return redirect()->route('language.index')->with('success', 'زبان با موفقیت اضافه شد.');
    }

    public function edit($slug)
    {
        $language = Language::where('slug', $slug)->firstOrFail();
        return view('panel.language.edit', compact('language'));
    }

    public function update(Request $request, string $id)
    {
        $language = Language::findOrFail($id);

        $request->validate([
            'name'             => 'required|string|max:255',
            'primary_color'    => 'required|string',
            'secondary_color'  => 'required|string',
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'description'      => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $data = $request->only([
            'name', 'description', 'meta_description', 'primary_color', 'secondary_color'
        ]);

//        dd($data);

        if ($request->hasFile('logo')) {
            $destinationPath = public_path('images/language/');
            if ($language->logo && File::exists($destinationPath . $language->logo)) {
                File::delete($destinationPath . $language->logo);
            }
            $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move($destinationPath, $fileName);
            $data['logo'] = $fileName;
        }

        $language->update($data);

        $this->logActivity('updated', $language);

        return redirect()->route('language.index')->with('success', 'زبان با موفقیت ویرایش شد.');
    }

    public function destroy(string $id)
    {


//        حذف لوگو اگر وجود داشت

        $language = Language::findOrFail($id);

        $destinationPath = public_path('images/language/');

        if ($language->logo && File::exists($destinationPath . $language->logo)) {
            File::delete($destinationPath . $language->logo);
        }

        $this->logActivity('deleted', $language);

        $language->delete();

        return redirect()->route('language.index')->with('success', 'زبان با موفقیت حذف شد.');
    }
}
