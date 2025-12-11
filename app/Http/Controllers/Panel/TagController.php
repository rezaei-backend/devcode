<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $tags = Tag::latest()->paginate(30);
        return view('panel.tag.index', compact('tags'));
    }

    public function create()
    {
        return view('panel.tag.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tag,name',
        ]);

        $slug = Str::slug($request->name, '-');
        $originalSlug = $slug;
        $count = 1;
        while (Tag::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        $this->logActivity('created', $tag);

        return redirect()->route('tag.index')->with('success', 'تگ با موفقیت اضافه شد.');
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('panel.tag.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:tag,name,' . $id,
        ]);

        $slug = Str::slug($request->name, '-');
        $originalSlug = $slug;
        $count = 1;
        while (Tag::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $tag->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        $this->logActivity('updated', $tag);

        return redirect()->route('tag.index')->with('success', 'تگ با موفقیت ویرایش شد.');
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $this->logActivity('deleted', $tag);
        $tag->blogs()->detach(); // یا $tag->detach() اگر متد عمومی داری
        $tag->delete();

        return redirect()->route('tag.index')->with('success', 'تگ با موفقیت حذف شد.');
    }
}
