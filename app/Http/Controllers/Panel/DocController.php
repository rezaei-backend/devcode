<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use App\Models\Subject;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class DocController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $docs = Doc::with(['subject.langitem'])->latest()->paginate(15);
        return view('panel.doc.index', compact('docs'));
    }

    public function create()
    {
        $subjects = Subject::with('langitem')->get();
        return view('panel.doc.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|unique:docs,title|max:255',
            'subject_id'   => 'required|exists:subjects,id',
            'content'      => 'required',
            'example_code' => 'required',
            'output'       => 'required',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/docs'), $fileName);
            $validated['image'] = $fileName;
        }

        $validated['slug'] = \Str::slug($validated['title']);
        $doc = Doc::create($validated);

        $this->logActivity('created', $doc);

        return redirect()->route('doc.index')->with('success', 'مستند با موفقیت ایجاد شد.');
    }

    public function show(string $id)
    {
        $doc = Doc::with(['subject.langitem'])->findOrFail($id);
        return view('panel.doc.show', compact('doc'));
    }

    public function edit(string $id)
    {
        $doc = Doc::findOrFail($id);
        $subjects = Subject::with('langitem')->get();
        return view('panel.doc.edit', compact('doc', 'subjects'));
    }

    public function update(Request $request, string $id)
    {
        $doc = Doc::findOrFail($id);

        $titleRule = $request->title !== $doc->title
            ? 'required|unique:docs,title|max:255'
            : 'required|max:255';

        $validated = $request->validate([
            'title'        => $titleRule,
            'subject_id'   => 'required|exists:subjects,id',
            'content'      => 'required',
            'example_code' => 'required',
            'output'       => 'required',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'remove_image' => 'sometimes|in:1',
        ]);

        $data = $request->only(['title', 'subject_id', 'content', 'example_code', 'output']);
        $data['slug'] = \Str::slug($data['title']);

        $destinationPath = public_path('images/docs');

        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($doc->image && file_exists($destinationPath . '/' . $doc->image)) {
                unlink($destinationPath . '/' . $doc->image);
            }
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($doc->image && file_exists($destinationPath . '/' . $doc->image)) {
                unlink($destinationPath . '/' . $doc->image);
            }
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move($destinationPath, $fileName);
            $data['image'] = $fileName;
        }

        $doc->update($data);

        $this->logActivity('updated', $doc);

        return redirect()->route('doc.index')->with('success', 'مستند با موفقیت بروزرسانی شد.');
    }

    public function destroy(string $id)
    {
        $doc = Doc::findOrFail($id);

        $path = public_path('images/docs/' . $doc->image);
        if ($doc->image && file_exists($path)) {
            unlink($path);
        }

        $this->logActivity('deleted', $doc);

        $doc->delete();

        return redirect()->route('doc.index')->with('success', 'مستند با موفقیت حذف شد.');
    }
}
