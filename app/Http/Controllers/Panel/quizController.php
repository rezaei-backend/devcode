<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Quiz;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class quizController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $quizzes = Quiz::latest()->paginate(10);
        return view('panel.quiz.index', compact('quizzes'));
    }

    public function create()
    {
        $languages = Language::all();
        return view('panel.quiz.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'language_id'      => 'required|exists:languages,id',
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $quiz = Quiz::create($request->only(['language_id', 'title', 'description', 'duration_minutes']));

        $this->logActivity('created', $quiz);

        return redirect()->route('quiz.index')->with('success', 'آزمون با موفقیت ثبت شد.');
    }

    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        $languages = Language::all();
        return view('panel.quiz.edit', compact('quiz', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'language_id'      => 'required|exists:languages,id',
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $quiz->update($request->only(['language_id', 'title', 'description', 'duration_minutes']));

        $this->logActivity('updated', $quiz);

        return redirect()->route('quiz.index')->with('success', 'آزمون با موفقیت به‌روزرسانی شد.');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);

        foreach ($quiz->questions as $question) {
            $question->options()->delete();
            $question->delete();
        }

        $quiz->questions()->detach();
        $quiz->delete();

        $this->logActivity('deleted', $quiz);

        return redirect()->route('quiz.index')->with('success', 'آزمون و تمام سوالات و گزینه‌ها با موفقیت حذف شدند.');
    }
}
