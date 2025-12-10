<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $blogs = Blog::with(['category', 'tags'])->latest()->paginate(15);
        return view('panel.blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('panel.blog.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
            'content'          => 'required|string',
            'category_id'      => 'required|exists:category,id',
            'tags'             => 'nullable|string', // حالا string میاد (مثل: laravel|php|برنامه‌نویسی)
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // اسلاگ خودکار از عنوان
        $slug = Str::slug($request->title, '-');
        $originalSlug = $slug;
        $count = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $data = $request->only(['title', 'content', 'category_id', 'meta_description']);
        $data['slug'] = $slug;
        $data['meta_title'] = $request->filled('meta_title') ? $request->meta_title : $request->title;

        // آپلود تصویر
        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/blog'), $fileName);
            $data['image'] = $fileName;
        }

        $blog = Blog::create($data);

        // مدیریت تگ‌ها (هوشمند + ساخت تگ جدید)
        $tagNames = $request->tags ? array_filter(explode('|', $request->tags)) : [];
        $tagIds = [];

        foreach ($tagNames as $name) {
            $name = trim($name);
            if ($name === '') continue;

            $tag = Tag::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
            $tagIds[] = $tag->id;
        }

        $blog->tags()->sync($tagIds);

        $this->logActivity('created', $blog);

        return redirect()->route('blog.index')->with('success', 'مقاله با موفقیت ایجاد شد.');
    }

    public function edit($id)
    {
        $blog = Blog::with('tags')->findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('panel.blog.edit', compact('blog', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title'            => 'required|string|max:255',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
            'remove_image'     => 'nullable|in:1',
            'content'          => 'required|string',
            'category_id'      => 'required|exists:category,id',
            'tags'             => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // اسلاگ خودکار از عنوان جدید
        $slug = Str::slug($request->title, '-');
        $originalSlug = $slug;
        $count = 1;
        while (Blog::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $data = $request->only(['title', 'content', 'category_id', 'meta_description']);
        $data['slug'] = $slug;
        $data['meta_title'] = $request->filled('meta_title') ? $request->meta_title : $request->title;

        // مدیریت تصویر
        if ($request->hasFile('image')) {
            if ($blog->image && File::exists(public_path('images/blog/' . $blog->image))) {
                File::delete(public_path('images/blog/' . $blog->image));
            }
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/blog'), $fileName);
            $data['image'] = $fileName;
        }

        // حذف تصویر فعلی
        if ($request->remove_image == '1') {
            if ($blog->image && File::exists(public_path('images/blog/' . $blog->image))) {
                File::delete(public_path('images/blog/' . $blog->image));
            }
            $data['image'] = null;
        }

        $blog->update($data);

        // مدیریت تگ‌ها
        $tagNames = $request->tags ? array_filter(explode('|', $request->tags)) : [];
        $tagIds = [];

        foreach ($tagNames as $name) {
            $name = trim($name);
            if ($name === '') continue;

            $tag = Tag::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
            $tagIds[] = $tag->id;
        }

        $blog->tags()->sync($tagIds);

        $this->logActivity('updated', $blog);

        return redirect()->route('blog.index')->with('success', 'مقاله با موفقیت به‌روزرسانی شد.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // حذف تصویر
        if ($blog->image && File::exists(public_path('images/blog/' . $blog->image))) {
            File::delete(public_path('images/blog/' . $blog->image));
        }

        $this->logActivity('deleted', $blog);
        $blog->tags()->detach();
        $blog->delete();

        return redirect()->route('blog.index')->with('success', 'مقاله با موفقیت حذف شد.');
    }
}
