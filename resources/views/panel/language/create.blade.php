@extends('Panel.Layouts.master')
@section('title', 'ایجاد زبان برنامه‌نویسی جدید')
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ایجاد زبان برنامه‌نویسی جدید</h5>
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

                        <form action="{{ route('language.store') }}" method="POST" enctype="multipart/form-data" id="language-form">
                            @csrf

                            <!-- نام و متا توضیحات -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="font-weight-bold">نام زبان <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="meta_description" class="font-weight-bold">متا توضیحات (سئو)<span class="text-danger">*</span></label>
                                    <textarea class="form-control form-control-sm @error('meta_description') is-invalid @enderror"
                                              id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- توضیحات کامل با CKEditor -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">توضیحات کامل <span class="text-danger">*</span></label>
                                    <div id="editor-create">{!! old('description') !!}</div>
                                    <input type="hidden" name="description" id="content-create">
                                    @error('description')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- لوگو با Drag & Drop -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">لوگو زبان<span class="text-danger">*</span></label>
                                    <div class="image-upload-container" id="image-upload-create">
                                        <input type="file" id="image-input-create" name="logo" accept="image/*" hidden>
                                        <div class="drop-zone" id="drop-zone-create">
                                            <p class="drop-text">فایل را اینجا بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                            <div id="image-preview-create" class="image-preview mt-2"></div>
                                        </div>
                                    </div>
                                    <small class="text-muted">حداکثر ۲ مگابایت - jpg, png, gif, svg</small>
                                    @error('logo')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- رنگ‌ها -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="primary_color" class="font-weight-bold">رنگ اصلی</label>
                                    <input type="color" class="form-control form-control-lg @error('primary_color') is-invalid @enderror"
                                           id="primary_color" name="primary_color" value="{{ old('primary_color', '#3b82f6') }}">
                                    @error('primary_color')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="secondary_color" class="font-weight-bold">رنگ ثانویه</label>
                                    <input type="color" class="form-control form-control-lg"
                                           id="secondary_color" name="secondary_color" value="{{ old('secondary_color', '#1e40af') }}">
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary-rgba px-5 py-2">ایجاد زبان</button>
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
        .image-upload-container { margin-top: 0.5rem; }
        .drop-zone { border: 2px dashed #ccc; border-radius: 0.5rem; padding: 2rem; text-align: center; background: #fafafa; transition: all 0.3s ease; cursor: pointer; }
        .drop-zone.dragover { border-color: #1976d2; background: #e3f2fd; }
        .drop-zone .drop-text { margin: 0; color: #666; font-size: 0.95rem; }
        .image-preview { max-height: 200px; overflow: hidden; border-radius: 0.375rem; margin-top: 0.5rem; text-align: center; }
        .image-preview img { max-height: 180px; border-radius: 0.375rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .ck-editor__editable { min-height: 400px; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropZoneCreate = document.getElementById('drop-zone-create');
            const inputCreate = document.getElementById('image-input-create');
            const previewCreate = document.getElementById('image-preview-create');

            dropZoneCreate.addEventListener('click', () => inputCreate.click());
            inputCreate.addEventListener('change', e => e.target.files[0] && showPreview(e.target.files[0], previewCreate));

            ['dragover', 'dragenter'].forEach(ev => dropZoneCreate.addEventListener(ev, e => { e.preventDefault(); dropZoneCreate.classList.add('dragover'); }));
            ['dragleave', 'dragend'].forEach(ev => dropZoneCreate.addEventListener(ev, () => dropZoneCreate.classList.remove('dragover')));
            dropZoneCreate.addEventListener('drop', e => {
                e.preventDefault();
                dropZoneCreate.classList.remove('dragover');
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    inputCreate.files = e.dataTransfer.files;
                    showPreview(file, previewCreate);
                }
            });

            function showPreview(file, el) {
                const reader = new FileReader();
                reader.onload = e => el.innerHTML = `<img src="${e.target.result}" alt="پیش‌نمایش">`;
                reader.readAsDataURL(file);
            }

            let editorCreate;
            ClassicEditor.create(document.querySelector('#editor-create'), {
                language: 'fa',
                toolbar: { items: ['heading','|','bold','italic','underline','|','link','bulletedList','numberedList','|','insertTable','blockQuote','undo','redo'] },
                fontFamily: { options: ['default','Arial','Tahoma','IranSans','Vazir'] }
            }).then(ed => {
                editorCreate = ed;
                document.getElementById('language-form').addEventListener('submit', () => {
                    document.getElementById('content-create').value = editorCreate.getData();
                });
            });
        });
    </script>
@endsection
