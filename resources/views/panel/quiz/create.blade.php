@extends('panel.layouts.master')
@section('title', 'ایجاد آزمون جدید')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ایجاد آزمون جدید</h5>
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

                        <form action="{{ route('quiz.store') }}" method="POST">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">زبان برنامه‌نویسی <span class="text-danger">*</span></label>
                                    <select name="language_id" class="form-control form-control-sm" required>
                                        <option value="">انتخاب زبان</option>
                                        @foreach($languages as $language)
                                            <option value="{{ $language->id }}" {{ old('language_id') == $language->id ? 'selected' : '' }}>
                                                {{ $language->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('language_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="font-weight-bold">عنوان آزمون <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control form-control-sm"
                                           value="{{ old('title') }}" placeholder="مثلاً: آزمون PHP پیشرفته" required>
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">توضیحات آزمون <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" rows="6" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="font-weight-bold">مدت زمان آزمون (دقیقه) <span class="text-danger">*</span></label>
                                    <input type="number" name="duration_minutes" class="form-control form-control-sm"
                                           value="{{ old('duration_minutes') }}" min="1" placeholder="مثلاً 60" required>
                                    @error('duration_minutes')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary-rgba px-5 py-2">ایجاد آزمون</button>
                                <a href="{{ route('quiz.index') }}" class="btn btn-outline-secondary px-5 py-2 ms-3">لغو</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
