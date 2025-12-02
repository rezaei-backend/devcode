@extends('Panel.Layouts.master')
@section('title', 'ویرایش زبان: {{ $language->name }}')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ویرایش زبان: {{ $language->name }}</h5>
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

                        <form action="{{ route('language.update', $language->id) }}" method="POST" enctype="multipart/form-data" id="language-form-edit">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">نام زبان <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name', $language->name) }}" required>
                                    @error('name') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">اسلاگ</label>
                                    <input type="text" class="form-control form-control-sm bg-light" value="{{ $language->slug }}" readonly>
                                </div>
                            </div>

                            <!-- فقط نمایش لوگو فعلی + امکان آپلود جدید -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    @if ($language->logo)
                                        <div class="current-image-box p-3 border rounded bg-light mb-3">
                                            <label class="font-weight-bold d-block mb-2">لوگو فعلی</label>
                                            <div class="text-center">
                                                <img src="{{ asset('images/language/' . $language->logo) }}" class="img-thumbnail" style="max-height:180px;">
                                            </div>
                                        </div>
                                    @endif

                                    <label class="font-weight-bold">لوگو جدید (برای جایگزینی لوگو فعلی)</label>
                                    <div class="image-upload-container" id="image-upload-edit">
                                        <input type="file" id="image-input-edit" name="logo" accept="image/*" hidden>
                                        <div class="drop-zone" id="drop-zone-edit">
                                            <p class="drop-text">فایل را بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                            <div id="image-preview-edit" class="image-preview mt-2"></div>
                                        </div>
                                    </div>
                                    <small class="text-muted">در صورت آپلود تصویر جدید، تصویر قبلی به صورت خودکار جایگزین می‌شود.</small>
                                    @error('logo') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- بقیه فیلدها مثل قبل -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">توضیحات کامل</label>
                                    <div id="editor-edit">{!! old('description', $language->description) !!}</div>
                                    <input type="hidden" name="description" id="content-edit">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">رنگ اصلی</label>
                                    <input type="color" class="form-control form-control-lg" name="primary_color"
                                           value="{{ old('primary_color', $language->primary_color) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">رنگ ثانویه</label>
                                    <input type="color" class="form-control form-control-lg" name="secondary_color"
                                           value="{{ old('secondary_color', $language->secondary_color ?? '#666666') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">متا توضیحات (سئو)</label>
                                    <textarea class="form-control form-control-sm" name="meta_description" rows="3">{{ old('meta_description', $language->meta_description) }}</textarea>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary-rgba px-5 py-2">ذخیره تغییرات</button>
                                <a href="{{ route('language.index') }}" class="btn btn-outline-secondary px-5 py-2 ms-2">لغو</a>
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
        .drop-zone { border: 2px dashed #ccc; border-radius: 0.5rem; padding: 2rem; text-align: center; background: #fafafa; transition: all 0.3s ease; cursor: pointer; }
        .drop-zone.dragover { border-color: #1976d2; background: #e3f2fd; }
        .image-preview img { max-height: 180px; border-radius: 0.375rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .ck-editor__editable { min-height: 400px; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropZone = document.getElementById('drop-zone-edit');
            const input = document.getElementById('image-input-edit');
            const preview = document.getElementById('image-preview-edit');

            dropZone.addEventListener('click', () => input.click());
            input.addEventListener('change', () => {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => preview.innerHTML = `<img src="${e.target.result}" alt="پیش‌نمایش">`;
                    reader.readAsDataURL(input.files[0]);
                }
            });

            ['dragover', 'dragenter'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.add('dragover'); }));
            ['dragleave', 'dragend'].forEach(e => dropZone.addEventListener(e, () => dropZone.classList.remove('dragover')));
            dropZone.addEventListener('drop', e => {
                e.preventDefault();
                dropZone.classList.remove('dragover');
                if (e.dataTransfer.files.length) {
                    input.files = e.dataTransfer.files;
                    const reader = new FileReader();
                    reader.onload = ev => preview.innerHTML = `<img src="${ev.target.result}" alt="پیش‌نمایش">`;
                    reader.readAsDataURL(e.dataTransfer.files[0]);
                }
            });

            // CKEditor
            let editorEdit;
            ClassicEditor.create(document.querySelector('#editor-edit'), { language: 'fa' })
                .then(editor => {
                    editorEdit = editor;
                    document.getElementById('language-form-edit').addEventListener('submit', () => {
                        document.getElementById('content-edit').value = editor.getData();
                    });
                });
        });
    </script>
@endsection
