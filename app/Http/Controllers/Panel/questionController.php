<?php
//
//namespace App\Http\Controllers\Panel;
//
//use App\Http\Controllers\Controller;
//use App\Models\Question;
//use App\Models\Quiz;
//use App\Models\Subject;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
//
//class questionController extends Controller
//{
//
//
//    public function index()
//    {
//        // بارگذاری رابطه subject و quizzes و زبان هر quiz
//        $questions = Question::with(['subject', 'quizzes.language'])->paginate(10);
//        return view('panel.question.index', compact('questions'));
//    }
//
//    /**
//     * فرم ایجاد سوال
//     */
//    public function create()
//    {
//        $subjects = Subject::all();
//        $quizzes = Quiz::all(); // اگر بخوای به سوال کوییز وصل کنی
//        return view('panel.question.create', compact('subjects', 'quizzes'));
//    }
//
//    /**
//     * ذخیره سوال جدید و گزینه‌ها
//     */
//    public function store(Request $request)
//    {
//        $request->validate([
//            'subject_id' => 'required|exists:subjects,id',
//            'question_text' => 'required|string',
//            'difficulty' => 'required|in:easy,medium,hard',
//            'explanation' => 'nullable|string',
//            'is_active' => 'required|boolean',
//            'options' => 'required|array|size:4',
//            'options.*.option_text' => 'required|string',
//            'options.*.is_correct' => 'required|boolean',
//        ]);
//
//        DB::transaction(function() use ($request) {
//            $question = Question::create([
//                'subject_id' => $request->subject_id,
//                'question_text' => $request->question_text,
//                'difficulty' => $request->difficulty,
//                'explanation' => $request->explanation,
//                'is_active' => $request->is_active,
//            ]);
//
//            // ایجاد گزینه‌ها
//            foreach ($request->options as $opt) {
//                $question->options()->create([
//                    'option_text' => $opt['option_text'],
//                    'is_correct' => $opt['is_correct'],
//                ]);
//            }
//
//            // اگر میخوای سوال رو به کوییز وصل کنی، مثلا فقط یک کوییز:
//            // $question->quizzes()->attach($request->quiz_id);
//        });
//
//        return redirect()->route('question.index')->with('success', 'سوال و گزینه‌ها با موفقیت اضافه شد.');
//    }
//
//
//
//
//
//
//
//
//
//
//
//    public function edit(Question $question)
//    {
//        $subjects = Subject::all();
//        $quizzes = Quiz::all(); // اگر میخوای به سوال کوییز وصل کنی
//        $question->load('options');
//        return view('panel.question.edit', compact('question', 'subjects', 'quizzes'));
//    }
//
//
//
//
//
//
//
//
//    public function update(Request $request, Question $question)
//    {
//        $request->validate([
//            'subject_id' => 'required|exists:subjects,id',
//            'question_text' => 'required|string',
//            'difficulty' => 'required|in:easy,medium,hard',
//            'explanation' => 'nullable|string',
//            'is_active' => 'required|boolean',
//            'options' => 'required|array|size:4',
//            'options.*.option_text' => 'required|string',
//            'options.*.is_correct' => 'required|boolean',
//        ]);
//
//        DB::transaction(function() use ($request, $question) {
//            // بروزرسانی سوال
//            $question->update([
//                'subject_id' => $request->subject_id,
//                'question_text' => $request->question_text,
//                'difficulty' => $request->difficulty,
//                'explanation' => $request->explanation,
//                'is_active' => $request->is_active,
//            ]);
//
//            // حذف گزینه‌های قبلی و اضافه کردن گزینه‌های جدید
//            $question->options()->delete();
//
//            foreach ($request->options as $opt) {
//                $question->options()->create([
//                    'option_text' => $opt['option_text'],
//                    'is_correct' => $opt['is_correct'],
//                ]);
//            }
//        });
//
//        return redirect()->route('question.index')->with('success', 'سوال و گزینه‌ها با موفقیت بروزرسانی شد.');
//    }
//
//    /**
//     * حذف سوال و گزینه‌ها
//     */
//    public function destroy(Question $question)
//    {
//        DB::transaction(function() use ($question) {
//            $question->options()->delete(); // حذف گزینه‌ها
//            $question->delete(); // حذف سوال
//        });
//
//        return redirect()->route('question.index')->with('success', 'سوال و گزینه‌ها با موفقیت حذف شدند.');
//    }
//
//
//
//}


namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class questionController extends Controller
{

    public function index($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);

        $questions = $quiz->questions()
            ->with(['options'])
            ->get();

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
            'question_text' => 'required',
            'difficulty' => 'required',
            'is_active' => 'required',
            'options' => 'required|array|min:4',
            'correct_option' => 'required|integer',
        ]);

        $question = Question::create([
            'question_text' => $validated['question_text'],
            'difficulty' => $validated['difficulty'],
            'explanation' => $request->explanation,
            'is_active' => $validated['is_active'],
        ]);

        $quiz->questions()->attach($question->id);

        foreach ($validated['options'] as $index => $text) {
            Option::create([
                'question_id' => $question->id,
                'option_text' => $text,
                'is_correct' => $validated['correct_option'] == $index ? 1 : 0,
            ]);
        }

        return redirect()
            ->route('question.index', $quiz_id)
            ->with('success', 'سؤال با موفقیت ایجاد شد');
    }
    public function update(Request $request, $quiz_id, $question_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);
        $question = Question::with('options')->findOrFail($question_id);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'difficulty'    => 'required|string',
            'is_active'     => 'required|boolean',
            'options.*'     => 'required|string',
            'correct_option'=> 'required|integer',
            'explanation'   => 'nullable|string',
        ]);

        // بروزرسانی سؤال
        $question->update([
            'question_text' => $validated['question_text'],
            'difficulty'    => $validated['difficulty'],
            'is_active'     => $validated['is_active'],
            'explanation'   => $validated['explanation'] ?? null,
        ]);

        // بروزرسانی گزینه‌ها
        foreach ($question->options as $i => $option) {
            $option->update([
                'option_text' => $validated['options'][$i],
                'is_correct'  => $i == $validated['correct_option'] ? 1 : 0,
            ]);
        }

        return redirect()
            ->route('question.index', $quiz->id)
            ->with('success', 'سؤال با موفقیت به‌روزرسانی شد.');
    }
    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);

        // حذف سوالات و گزینه‌هایشان
        foreach ($quiz->questions as $question) {

            // حذف گزینه‌های سوال
            $question->options()->delete();

            // حذف خود سوال
            $question->delete();
        }

        // حذف روابط pivot
        $quiz->questions()->detach();

        // حذف خود آزمون
        $quiz->delete();

        return redirect()->route('quiz.index')->with('success', 'آزمون و تمام سوالات و گزینه‌ها با موفقیت حذف شدند.');
    }



}
