@extends('Panel.Layouts.master')
@section('title', 'ویرایش موضوع: ' . Str::limit($subject->title, 50))

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ویرایش موضوع: {{ Str::limit($subject->title, 50) }}</h5>
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

                        @if(session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        <form action="{{ route('subject.update', $subject->slug) }}" method="POST" id="subject-form-edit">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="title" class="font-weight-bold">عنوان موضوع <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="title"
                                           value="{{ old('title', $subject->title) }}" required>
                                    @error('title')<span class="text-danger d-block mt-1">{{ $message }}</span>@enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="language_id" class="font-weight-bold">زبان برنامه‌نویسی <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm" name="language_id" required>
                                        <option value="">انتخاب زبان</option>
                                        @foreach ($langs as $lang)
                                            <option value="{{ $lang->id }}"
                                                {{ old('language_id', $subject->language_id) == $lang->id ? 'selected' : '' }}>
                                                {{ $lang->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('language_id')<span class="text-danger d-block mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">توضیحات موضوع <span class="text-danger">*</span></label>
                                    <div id="editor-edit">{!! old('description', $subject->description) !!}</div>
                                    <input type="hidden" name="description" id="description-edit">
                                    @error('description')<span class="text-danger d-block mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary-rgba px-5 py-2">ذخیره تغییرات</button>
                                <a href="{{ route('subject.index') }}" class="btn btn-outline-secondary px-5 py-2 ms-2">لغو</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/translations/fa.js"></script>
    <style>
        .ck-editor__editable { min-height: 400px; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let editorEdit;
            ClassicEditor
                .create(document.querySelector('#editor-edit'), {
                    language: 'fa',
                    toolbar: {
                        items: [
                            'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
                            'alignment', '|', 'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|', 'link', 'blockQuote', 'insertTable', 'mediaEmbed',
                            'undo', 'redo', '|', 'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor',
                            '|', 'code', 'codeBlock', '|', 'horizontalLine'
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    fontFamily: { options: ['default', 'Arial', 'Tahoma', 'IranSans', 'Vazir', 'B Nazanin'] },
                    fontSize: { options: [10, 12, 14, 'default', 18, 22, 26] },
                })
                .then(editor => {
                    editorEdit = editor;
                    document.getElementById('subject-form-edit').addEventListener('submit', () => {
                        document.getElementById('description-edit').value = editor.getData();
                    });
                })
                .catch(error => console.error(error));
        });
    </script>
@endsection
