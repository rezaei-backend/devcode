<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class questionController extends Controller
{
    use LogsActivity;

    public function index($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $questions = $quiz->questions()->with('options')->get();
        return view('panel.question.index', compact('quiz', 'questions'));
    }

    public function create($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        return view('panel.question.create', compact('quiz'));
    }

    public function store(Request $request, $quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);

        $validated = $request->validate([
            'question_text'  => 'required|string',
            'difficulty'     => 'required|in:easy,medium,hard',
            'is_active'      => 'required|in:0,1',
            'explanation'    => 'nullable|string',
            'options'        => 'required|array|min:4',
            'options.*'      => 'required|string',
            'correct_option' => 'required|integer',
        ]);

        $question = Question::create([
            'question_text' => $validated['question_text'],
            'difficulty'    => $validated['difficulty'],
            'explanation'   => $validated['explanation'] ?? null,
            'is_active'     => $validated['is_active'],
        ]);

        $quiz->questions()->attach($question->id);

        foreach ($validated['options'] as $index => $text) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => $text,
                'is_correct'  => $index == $validated['correct_option'] ? 1 : 0,
            ]);
        }

        $this->logActivity('created', $question);

        return redirect()->route('question.index', $quiz_id)->with('success', 'سوال با موفقیت ایجاد شد.');
    }

    public function edit($quiz_id, $question)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $question = Question::with('options')->findOrFail($question);
        if (!$quiz->questions()->where('question_id', $question->id)->exists()) abort(404);
        return view('panel.question.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, $quiz_id, $question_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $question = Question::with('options')->findOrFail($question_id);
        if (!$quiz->questions()->where('question_id', $question->id)->exists()) abort(403);

        $validated = $request->validate([
            'question_text'  => 'required|string',
            'difficulty'     => 'required|in:easy,medium,hard',
            'is_active'      => 'required|in:0,1',
            'explanation'    => 'nullable|string',
            'options.*'      => 'required|string',
            'correct_option' => 'required|integer',
        ]);

        $question->update([
            'question_text' => $validated['question_text'],
            'difficulty'    => $validated['difficulty'],
            'explanation'   => $validated['explanation'] ?? null,
            'is_active'     => $validated['is_active'],
        ]);

        foreach ($question->options as $index => $option) {
            $option->update([
                'option_text' => $validated['options'][$index],
                'is_correct'  => $index == $validated['correct_option'] ? 1 : 0,
            ]);
        }

        $this->logActivity('updated', $question);

        return redirect()->route('question.index', $quiz_id)->with('success', 'سوال با موفقیت بروزرسانی شد.');
    }

    public function destroy($quiz_id, $question_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $question = Question::findOrFail($question_id);
        if (!$quiz->questions()->where('question_id', $question->id)->exists()) abort(403);

        $question->options()->delete();
        $quiz->questions()->detach($question->id);
        $question->delete();

        $this->logActivity('deleted', $question);

        return redirect()->route('question.index', $quiz_id)->with('success', 'سوال با موفقیت حذف شد.');
    }
}
