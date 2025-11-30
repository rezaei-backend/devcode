<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $categories = Category::latest()->paginate(20);
        return view('panel.category.index', compact('categories'));
    }

    public function create()
    {
        return view('panel.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:category,name',
        ]);

        $slug = Str::slug($request->name, '-');
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        $this->logActivity('created', $category);

        return redirect()->route('category.index')->with('success', 'دسته‌بندی با موفقیت اضافه شد.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('panel.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:category,name,' . $id,
        ]);

        $slug = Str::slug($request->name, '-');
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        $this->logActivity('updated', $category);

        return redirect()->route('category.index')->with('success', 'دسته‌بندی با موفقیت ویرایش شد.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $this->logActivity('deleted', $category);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }
}
