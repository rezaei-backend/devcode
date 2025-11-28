@extends('panel.layouts.master')
@section('title', 'ویرایش آزمون: ' . $quiz->title)

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ویرایش آزمون: {{ $quiz->title }}</h5>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('quiz.update', $quiz->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">زبان برنامه‌نویسی <span class="text-danger">*</span></label>
                                    <select name="language_id" class="form-control form-control-sm" required>
                                        <option value="">انتخاب زبان</option>
                                        @foreach($languages as $language)
                                            <option value="{{ $language->id }}"
                                                {{ old('language_id', $quiz->language_id) == $language->id ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="font-weight-bold">عنوان آزمون <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control form-control-sm"
                                           value="{{ old('title', $quiz->title) }}" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">توضیحات آزمون <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" rows="6" required>{{ old('description', $quiz->description) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="font-weight-bold">مدت زمان آزمون (دقیقه) <span class="text-danger">*</span></label>
                                    <input type="number" name="duration_minutes" class="form-control form-control-sm"
                                           value="{{ old('duration_minutes', $quiz->duration_minutes) }}" min="1" required>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success-rgba px-5 py-2">ذخیره تغییرات</button>
                                <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary px-5 py-2 ms-3">لغو</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
