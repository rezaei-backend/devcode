@extends('panel.layouts.master')
@section('title', 'ویرایش مستند: ' . Str::limit($doc->title, 40))

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ویرایش مستند: {{ $doc->title }}</h5>
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

                        <form action="{{ route('doc.update', $doc->id) }}" method="POST" enctype="multipart/form-data" id="doc-form-edit">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">عنوان مستند <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                           value="{{ old('title', $doc->title) }}" required>
                                    @error('title')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">موضوع <span class="text-danger">*</span></label>
                                    <select name="subject_id" class="form-control @error('subject_id') is-invalid @enderror" required>
                                        <option value="">انتخاب موضوع</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old('subject_id', $doc->subject_id) == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->langitem->name ?? 'بدون زبان' }} › {{ $subject->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- بخش تصویر با دکمه حذف (فقط اگر عکس داشته باشه) -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    @if($doc->image)
                                        <div class="current-image-box p-3 border rounded bg-light mb-3" id="current-image-box">
                                            <label class="font-weight-bold d-block mb-2">تصویر فعلی</label>
                                            <div class="text-center position-relative d-inline-block">
                                                <img src="{{ asset('images/docs/' . $doc->image) }}" class="img-thumbnail" style="max-height:180px;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 mt-2 me-2"
                                                        onclick="removeCurrentImage()">حذف</button>
                                            </div>
                                        </div>

                                        <!-- چک‌باکس مخفی برای ارسال درخواست حذف -->
                                        <input type="hidden" name="remove_image" value="0">
                                        <input type="checkbox" name="remove_image" value="1" id="remove_image_checkbox" class="d-none">
                                    @endif

                                    <label class="font-weight-bold">تصویر جدید (اختیاری)</label>
                                    <div class="image-upload-container">
                                        <input type="file" id="image-input-edit" name="image" accept="image/*" hidden>
                                        <div class="drop-zone" id="drop-zone-edit">
                                            <p class="drop-text">فایل را بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                            <div id="image-preview-edit" class="image-preview mt-2"></div>
                                        </div>
                                    </div>
                                    @error('image')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- بقیه فیلدها مثل create -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">کد نمونه <span class="text-danger">*</span></label>
                                    <textarea name="example_code" rows="10" class="form-control monospace @error('example_code') is-invalid @enderror" required>{{ old('example_code', $doc->example_code) }}</textarea>
                                    @error('example_code') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">خروجی کد <span class="text-danger">*</span></label>
                                    <textarea name="output" rows="10" class="form-control monospace @error('output') is-invalid @enderror" required>{{ old('output', $doc->output) }}</textarea>
                                    @error('output') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">محتوای مستند <span class="text-danger">*</span></label>
                                    <div id="editor-edit">{!! old('content', $doc->content) !!}</div>
                                    <input type="hidden" name="content" id="content-edit">
                                    @error('content') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary-rgba px-5 py-2">ذخیره تغییرات</button>
                                <a href="{{ route('doc.index') }}" class="btn btn-outline-secondary px-5 py-2 ms-2">لغو</a>
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
        .drop-zone { border: 2px dashed #ccc; border-radius: 12px; padding: 40px; text-align: center; background: #fafafa; cursor: pointer; transition: .3s; }
        .drop-zone.dragover { border-color: #007bff; background: #e3f2fd; }
        .image-preview img { max-height: 180px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,.1); }
        .monospace { font-family: 'Courier New', Consolas, monospace; font-size: 0.95rem; }
        .ck-editor__editable { min-height: 500px; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Drag & Drop برای ویرایش
            const dropZoneEdit = document.getElementById('drop-zone-edit');
            const inputEdit = document.getElementById('image-input-edit');
            const previewEdit = document.getElementById('image-preview-edit');

            if (dropZoneEdit) {
                dropZoneEdit.addEventListener('click', () => inputEdit.click());
                inputEdit.addEventListener('change', () => inputEdit.files[0] && showPreview(inputEdit.files[0], previewEdit));
                ['dragover', 'dragenter'].forEach(e => dropZoneEdit.addEventListener(e, ev => { ev.preventDefault(); dropZoneEdit.classList.add('dragover'); }));
                ['dragleave', 'dragend'].forEach(e => dropZoneEdit.addEventListener(e, () => dropZoneEdit.classList.remove('dragover')));
                dropZoneEdit.addEventListener('drop', e => {
                    e.preventDefault(); dropZoneEdit.classList.remove('dragover');
                    if (e.dataTransfer.files[0]?.type.startsWith('image/')) {
                        inputEdit.files = e.dataTransfer.files;
                        showPreview(e.dataTransfer.files[0], previewEdit);
                        // اگر عکس جدید انتخاب شد → قصد حذف قبلی لغو بشه
                        if (document.getElementById('remove_image_checkbox')) {
                            document.getElementById('remove_image_checkbox').checked = false;
                        }
                    }
                });
            }

            function showPreview(file, previewElement) {
                const reader = new FileReader();
                reader.onload = e => previewElement.innerHTML = `<img src="${e.target.result}" alt="پیش‌نمایش">`;
                reader.readAsDataURL(file);
            }

            // تابع حذف تصویر فعلی
            window.removeCurrentImage = function () {
                const box = document.getElementById('current-image-box');
                if (box) box.remove();
                if (document.getElementById('remove_image_checkbox')) {
                    document.getElementById('remove_image_checkbox').checked = true;
                }
            };

            // CKEditor
            ClassicEditor.create(document.querySelector('#editor-edit'), { language: 'fa' })
                .then(editor => {
                    document.getElementById('doc-form-edit').addEventListener('submit', () => {
                        document.getElementById('content-edit').value = editor.getData();
                    });
                });
        });
    </script>
@endsection
