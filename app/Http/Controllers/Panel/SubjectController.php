<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Subject;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $subjects = Subject::with('language')->orderBy('created_at', 'desc')->paginate(10);
        $langs = Language::all();
        return view('panel.subject.index', compact('subjects', 'langs'));
    }

    public function create()
    {
        $langs = Language::all();
        return view('panel.subject.create', compact('langs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255|unique:subjects,title',
            'description' => 'required',
            'language_id' => 'required|exists:languages,id',
        ]);

        $subject = Subject::create($validated);

        $this->logActivity('created', $subject);

        return redirect()->route('subject.index')->with('message', 'موضوع با موفقیت ایجاد شد');
    }

    public function edit($subject)
    {
        $subject = Subject::where('slug', $subject)->firstOrFail();
        $langs = Language::all();
        return view('panel.subject.edit', compact('subject', 'langs'));
    }

    public function update(Request $request, $subject)
    {
        $subject = Subject::where('slug', $subject)->firstOrFail();

        $rules = [
            'description' => 'required',
            'language_id' => 'required|exists:languages,id',
            'title'       => 'required|string|max:255',
        ];

        if ($request->title !== $subject->title) {
            $rules['title'] .= '|unique:subjects,title';
        }

        $validated = $request->validate($rules);
        $subject->update($validated);

        $this->logActivity('updated', $subject);

        return redirect()->route('subject.index')->with('message', 'موضوع با موفقیت بروزرسانی شد');
    }

    public function destroy($subject)
    {
        $subject = Subject::where('slug', $subject)->firstOrFail();

        $this->logActivity('deleted', $subject);

        $subject->delete();

        return back()->with('message', 'موضوع با موفقیت حذف شد');
    }
}
