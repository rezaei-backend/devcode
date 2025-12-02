@extends('panel.layouts.master')
@section('title', 'ویرایش سوال')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ویرایش سوال در آزمون: {{ $quiz->title }}</h5>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('question.update', [$quiz->id, $question->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- متن سوال -->
                            <div class="mb-4">
                                <label class="font-weight-bold">متن سوال <span class="text-danger">*</span></label>
                                <textarea name="question_text" id="question_text" rows="6">{{ old('question_text', $question->question_text) }}</textarea>
                            </div>

                            <!-- درجه سختی و وضعیت -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">درجه سختی <span class="text-danger">*</span></label>
                                    <select name="difficulty" class="form-control" required>
                                        <option value="easy" {{ old('difficulty', $question->difficulty) == 'easy' ? 'selected' : '' }}>آسان</option>
                                        <option value="medium" {{ old('difficulty', $question->difficulty) == 'medium' ? 'selected' : '' }}>متوسط</option>
                                        <option value="hard" {{ old('difficulty', $question->difficulty) == 'hard' ? 'selected' : '' }}>سخت</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">وضعیت سوال</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" value="1" {{ old('is_active', $question->is_active) == 1 ? 'checked' : '' }}> فعال
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" value="0" {{ old('is_active', $question->is_active) == 0 ? 'checked' : '' }}> غیرفعال
                                    </div>
                                </div>
                            </div>

                            <!-- توضیحات پاسخ -->
                            <div class="mb-4">
                                <label class="font-weight-bold">توضیحات پاسخ (اختیاری)</label>
                                <textarea name="explanation" id="explanation" rows="4">{{ old('explanation', $question->explanation) }}</textarea>
                            </div>

                            <!-- گزینه‌ها -->
                            <div class="mb-4">
                                <label class="font-weight-bold">گزینه‌ها <span class="text-danger">*</span></label>
                                @foreach($question->options as $index => $option)
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light"><strong>{{ $index + 1 }}</strong></span>
                                        <input type="text" name="options[{{ $index }}]" class="form-control"
                                               value="{{ old("options.$index", $option->option_text) }}" required>
                                        <span class="input-group-text">
                                            <input type="radio" name="correct_option" value="{{ $index }}"
                                                   {{ old('correct_option', $option->is_correct ? $index : '') == $index ? 'checked' : '' }} required>
                                            <span class="me-2">درست</span>
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-5 py-2">ذخیره تغییرات</button>
                                <a href="{{ route('question.index', $quiz->id) }}" class="btn btn-outline-secondary px-5 py-2 ms-3">لغو</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/translations/fa.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#question_text'), { language: 'fa' });
        ClassicEditor.create(document.querySelector('#explanation'), { language: 'fa' });

        document.addEventListener('DOMContentLoaded', function () {
            ['#question_text', '#explanation'].forEach(selector => {
                const el = document.querySelector(selector);
                if (el) {
                    el.removeAttribute('required');
                    el.style.display = 'none';
                }
            });
        });
    </script>
@endsection
