@extends('panel.layouts.master')
@section('title','ایجاد آزمون')

@section('content')
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">ایجاد آزمون جدید</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('quiz.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                {{-- انتخاب زبان --}}
                                <div class="col-lg-6 mb-3">
                                    <label for="languageInput" class="form-label">انتخاب زبان <span class="text-danger">*</span></label>
                                    <select name="language_id"
                                            id="languageInput"
                                            class="form-control @error('language_id') is-invalid @enderror"
                                            required>
                                        <option value="">یک زبان انتخاب کنید</option>
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

                                {{-- عنوان آزمون --}}
                                <div class="col-lg-6 mb-3">
                                    <label for="titleInput" class="form-label">عنوان آزمون <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           name="title"
                                           id="titleInput"
                                           value="{{ old('title') }}"
                                           placeholder="عنوان آزمون را وارد کنید"
                                           required>
                                    @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- توضیحات آزمون --}}
                                <div class="col-lg-12 mb-3">
                                    <label for="descriptionInput" class="form-label">توضیحات <span class="text-danger">*</span></label>
                                    <textarea rows="5"
                                              class="form-control @error('description') is-invalid @enderror"
                                              name="description"
                                              id="descriptionInput"
                                              placeholder="توضیحات آزمون">{{ old('description') }}</textarea>
                                    @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- مدت زمان آزمون --}}
                                <div class="col-lg-3 mb-3">
                                    <label for="durationInput" class="form-label">مدت زمان (دقیقه) <span class="text-danger">*</span></label>
                                    <input type="number"
                                           class="form-control @error('duration_minutes') is-invalid @enderror"
                                           name="duration_minutes"
                                           id="durationInput"
                                           value="{{ old('duration_minutes') }}"
                                           placeholder="مثلاً 60"
                                           required>
                                    @error('duration_minutes')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">ثبت آزمون</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End row -->
    </div>
@endsection
