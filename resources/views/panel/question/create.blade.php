@extends('panel.layouts.master')
@section('title', 'ایجاد سوال جدید - ' . $quiz->title)

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ایجاد سوال جدید برای آزمون: {{ $quiz->title }}</h5>
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

                        <form action="{{ route('question.store', $quiz->id) }}" method="POST">
                            @csrf

                            <!-- متن سوال -->
                            <div class="mb-4">
                                <label class="font-weight-bold">متن سوال <span class="text-danger">*</span></label>
                                <textarea name="question_text" id="question_text" rows="6">{{ old('question_text') }}</textarea>
                                @error('question_text')
                                <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- درجه سختی و وضعیت -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">درجه سختی <span class="text-danger">*</span></label>
                                    <select name="difficulty" class="form-control" required>
                                        <option value="">انتخاب کنید</option>
                                        <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>آسان</option>
                                        <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>متوسط</option>
                                        <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>سخت</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold d-block">وضعیت سوال</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" value="1" id="active_yes" {{ old('is_active', 1) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active_yes">فعال</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" value="0" id="active_no" {{ old('is_active') == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active_no">غیرفعال</label>
                                    </div>
                                </div>
                            </div>

                            <!-- توضیحات پاسخ -->
                            <div class="mb-4">
                                <label class="font-weight-bold">توضیحات پاسخ (اختیاری)</label>
                                <textarea name="explanation" id="explanation" rows="4">{{ old('explanation') }}</textarea>
                            </div>

                            <!-- گزینه‌ها -->
                            <div class="mb-4">
                                <label class="font-weight-bold">گزینه‌ها <span class="text-danger">*</span></label>
                                <small class="text-muted d-block mb-3">یکی از گزینه‌ها را به عنوان پاسخ صحیح انتخاب کنید</small>

                                @for($i = 0; $i < 4; $i++)
                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-light">
                                            <strong>{{ $i + 1 }}</strong>
                                        </span>
                                        <input type="text" name="options[{{ $i }}]" class="form-control"
                                               placeholder="متن گزینه {{ $i + 1 }}" value="{{ old("options.$i") }}" required>
                                        <span class="input-group-text">
                                            <input type="radio" name="correct_option" value="{{ $i }}"
                                                   {{ old('correct_option') == $i ? 'checked' : '' }} required>
                                            <span class="me-2">درست</span>
                                        </span>
                                    </div>
                                @endfor

                                @error('options')
                                <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                                @error('correct_option')
                                <small class="text-danger d-block">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-5 py-2">ایجاد سوال</button>
                                <a href="{{ route('question.index', $quiz->id) }}" class="btn btn-outline-secondary px-5 py-2 ms-3">لغو</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/translations/fa.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#question_text'), { language: 'fa' })
            .catch(error => console.error(error));

        ClassicEditor
            .create(document.querySelector('#explanation'), { language: 'fa' })
            .catch(error => console.error(error));

        // حل مشکل required در textarea مخفی
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
