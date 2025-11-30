@extends('panel.layouts.master')
@section('title','ایجاد سوال جدید')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">ایجاد سوال جدید برای آزمون: {{ $quiz->title }}</h5>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('question.store', $quiz->id) }}" method="POST">
                            @csrf
                            <div class="row">

                                {{-- متن سوال --}}
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">متن سوال <span class="text-danger">*</span></label>
                                    <textarea name="question_text"
                                              class="form-control @error('question_text') is-invalid @enderror"
                                              rows="4"
                                              placeholder="متن سوال را وارد کنید"
                                              required>{{ old('question_text') }}</textarea>
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
                                        <option value="easy">آسان</option>
                                        <option value="medium">متوسط</option>
                                        <option value="hard">سخت</option>
                                    </select>
                                    @error('difficulty')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- فعال بودن --}}
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">فعال باشد؟</label><br>
                                    <input type="radio" name="is_active" value="1" checked> بله
                                    <input type="radio" name="is_active" value="0"> خیر
                                </div>

                                {{-- توضیح سوال --}}
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">توضیح (اختیاری)</label>
                                    <textarea name="explanation"
                                              rows="3"
                                              class="form-control">{{ old('explanation') }}</textarea>
                                </div>

                                {{-- گزینه‌ها --}}
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">گزینه‌ها</label>

                                    @for($i = 0; $i < 4; $i++)
                                        <div class="input-group mb-2">
                                            <input type="text"
                                                   name="options[{{ $i }}]"
                                                   class="form-control"
                                                   placeholder="متن گزینه"
                                                   required>

                                            <div class="input-group-text">
                                                <input type="radio"
                                                       name="correct_option"
                                                       value="{{ $i }}"
                                                       required>
                                                <span class="ml-1">درست</span>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">ثبت سوال</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
