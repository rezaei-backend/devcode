@extends('panel.layouts.master')
@section('title', 'ایجاد مستند جدید')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ایجاد مستند جدید</h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('doc.store') }}" method="POST" id="doc-form-create">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">عنوان مستند <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">موضوع <span class="text-danger">*</span></label>
                                    <select name="subject_id" class="form-control" required>
                                        <option value="">انتخاب موضوع</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->langitem->name ?? 'بدون زبان' }} › {{ $subject->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">کد نمونه <span class="text-danger">*</span></label>
                                    <textarea name="example_code" rows="10" class="form-control monospace" required>{{ old('example_code') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">خروجی کد <span class="text-danger">*</span></label>
                                    <textarea name="output" rows="10" class="form-control monospace" required>{{ old('output') }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">محتوای مستند <span class="text-danger">*</span></label>
                                    <div id="editor-create">{!! old('content') !!}</div>
                                    <input type="hidden" name="content" id="content-create">
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary-rgba px-5 py-2">ایجاد مستند</button>
                                <a href="{{ route('doc.index') }}" class="btn btn-outline-secondary px-5 py-2 ms-2">لغو</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .ck-editor__editable {
            min-height: 400px !important; /* ارتفاع واقعی ادیتور */
            max-height: 700px;
            overflow-y: auto;
        }
    </style>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#editor-create'), { language: 'fa' })
            .then(editor => {
                document.getElementById('doc-form-create').addEventListener('submit', () => {
                    document.getElementById('content-create').value = editor.getData();
                });
            });
    </script>
@endsection
