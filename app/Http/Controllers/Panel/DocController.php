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
        ]);

        $doc = Doc::create($validated);

        $this->logActivity('created', $doc);

        return redirect()->route('doc.index')->with('success', 'مستند با موفقیت ایجاد شد.');
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
        ]);

        $doc->update($validated);

        $this->logActivity('updated', $doc);

        return redirect()->route('doc.index')->with('success', 'مستند با موفقیت بروزرسانی شد.');
    }

    public function destroy(string $id)
    {
        $doc = Doc::findOrFail($id);

        $this->logActivity('deleted', $doc);

        $doc->delete();

        return redirect()->route('doc.index')->with('success', 'مستند با موفقیت حذف شد.');
    }
}
