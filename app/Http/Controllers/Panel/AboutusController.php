<?php

namespace App\Http\Controllers\Panel;

use App\Models\Aboutus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class AboutusController extends Controller
{
    public function edit()
    {
        $about = Aboutus::firstOrFail();
        return view('panel.about-us.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $about = Aboutus::firstOrFail();

        $validated = $request->validate([
            'title'         => 'nullable|string|min:3|max:255',
            'content'       => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_image'  => 'nullable|in:1',
        ]);

        $uploadPath = public_path('images/about');
        $imagePath = $about->image;

        if ($request->hasFile('image')) {

            if ($imagePath && File::exists($uploadPath . '/' . $imagePath)) {
                File::delete($uploadPath . '/' . $imagePath);
            }

            $file = $request->file('image');
            $fileName = 'about_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $fileName);
            $imagePath = $fileName;

        } elseif ($request->has('remove_image')) {
            if ($imagePath && File::exists($uploadPath . '/' . $imagePath)) {
                File::delete($uploadPath . '/' . $imagePath);
            }
            $imagePath = null;
        }

        $about->update([
            'title'   => $validated['title']   ?? $about->title,
            'content' => $validated['content'] ?? $about->content,
            'image'   => $imagePath,
        ]);

        return redirect()->back()->with('status', 'اطلاعات درباره ما با موفقیت ویرایش شد ✅');
    }
}
