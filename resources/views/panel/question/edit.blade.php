@extends('panel.layouts.master')
@section('title','ویرایش سوال')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">ویرایش سوال برای آزمون: {{ $quiz->title }}</h5>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('question.update', [$quiz->id, $question->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                {{-- متن سوال --}}
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">متن سوال <span class="text-danger">*</span></label>
                                    <textarea name="question_text"
                                              class="form-control @error('question_text') is-invalid @enderror"
                                              rows="4"
                                              required>{{ old('question_text', $question->question_text) }}</textarea>
                                    @error('question_text')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- درجه سختی --}}
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">درجه سختی <span class="text-danger">*</span></label>
                                    <select name="difficulty"
                                            class="form-control @error('difficulty') is-invalid @enderror"
                                            required>
                                        <option value="easy" {{ $question->difficulty == 'easy' ? 'selected' : '' }}>آسان</option>
                                        <option value="medium" {{ $question->difficulty == 'medium' ? 'selected' : '' }}>متوسط</option>
                                        <option value="hard" {{ $question->difficulty == 'hard' ? 'selected' : '' }}>سخت</option>
                                    </select>
                                    @error('difficulty')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- فعال بودن --}}
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">فعال باشد؟</label><br>
                                    <input type="radio" name="is_active" value="1" {{ $question->is_active ? 'checked' : '' }}> بله
                                    <input type="radio" name="is_active" value="0" {{ !$question->is_active ? 'checked' : '' }}> خیر
                                </div>

                                {{-- توضیح سوال --}}
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">توضیح (اختیاری)</label>
                                    <textarea name="explanation" rows="3" class="form-control">{{ old('explanation', $question->explanation) }}</textarea>
                                </div>

                                {{-- گزینه‌ها --}}
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">گزینه‌ها</label>

                                    @foreach($question->options as $i => $option)
                                        <div class="input-group mb-2">
                                            <input type="text"
                                                   name="options[{{ $i }}]"
                                                   class="form-control"
                                                   value="{{ old('options.'.$i, $option->option_text) }}"
                                                   placeholder="متن گزینه"
                                                   required>

                                            <div class="input-group-text">
                                                <input type="radio"
                                                       name="correct_option"
                                                       value="{{ $i }}"
                                                       {{ $option->is_correct ? 'checked' : '' }}
                                                       required>
                                                <span class="ml-1">درست</span>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">به‌روزرسانی سوال</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
