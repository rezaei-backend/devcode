@extends('panel.layouts.master')
@section('title', 'ویرایش درباره ما')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ویرایش صفحه درباره ما</h5>
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

                        <form action="{{ route('aboutus.update') }}" method="POST" enctype="multipart/form-data" id="aboutus-form-edit">
                            @csrf
                            @method('PUT')

                            <!-- عنوان -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">عنوان صفحه (اختیاری)</label>
                                    <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror"
                                           name="title" value="{{ old('title', $about->title) }}" placeholder="مثال: تیم ما، درباره پروژه، داستان ما">
                                    @error('title') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- تصویر فعلی + آپلود جدید -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    @if ($about->image)
                                        <div class="current-image-box p-3 border rounded bg-light mb-3">
                                            <label class="font-weight-bold d-block mb-2">تصویر فعلی</label>
                                            <div class="text-center">
                                                <img src="{{ asset('images/about/' . $about->image) }}" class="img-thumbnail" style="max-height:200px;">
                                            </div>
                                            <div class="mt-2">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="remove_image" value="1" class="custom-control-input">
                                                    <span class="custom-control-label text-danger">حذف تصویر فعلی</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <label class="font-weight-bold">
                                        {{ $about->image ? 'تصویر جدید (برای جایگزینی)' : 'آپلود تصویر' }}
                                    </label>
                                    <div class="image-upload-container" id="image-upload-edit">
                                        <input type="file" id="image-input-edit" name="image" accept="image/*" hidden>
                                        <div class="drop-zone" id="drop-zone-edit">
                                            <p class="drop-text">فایل را اینجا بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                            <div id="image-preview-edit" class="image-preview mt-2"></div>
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        فرمت‌های مجاز: jpg, jpeg, png, webp - حداکثر 2MB
                                    </small>
                                    @error('image') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- محتوا با CKEditor -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">محتوای صفحه درباره ما</label>
                                    <div id="editor-edit">{!! old('content', $about->content) !!}</div>
                                    <input type="hidden" name="content" id="content-edit">
                                    @error('content') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary-rgba px-5 py-2">
                                    ذخیره تغییرات
                                </button>
                                <a href="{{ route('aboutus.index') }}" class="btn btn-outline-secondary px-5 py-2 ms-2">
                                    بازگشت
                                </a>
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

    <style>
        .drop-zone {
            border: 2px dashed #ccc;
            border-radius: 0.5rem;
            padding: 2.5rem;
            text-align: center;
            background: #fafafa;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .drop-zone.dragover {
            border-color: #1976d2;
            background: #e3f2fd;
        }
        .image-preview img {
            max-height: 200px;
            border-radius: 0.375rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .ck-editor__editable {
            min-height: 420px !important;
        }
        .border-dashed {
            border-style: dashed !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Drag & Drop + پیش‌نمایش تصویر
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

            ['dragover', 'dragenter'].forEach(e => dropZone.addEventListener(e, ev => {
                ev.preventDefault(); dropZone.classList.add('dragover');
            }));
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
            ClassicEditor
                .create(document.querySelector('#editor-edit'), {
                    language: 'fa',
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo']
                })
                .then(editor => {
                    editorEdit = editor;
                    document.getElementById('aboutus-form-edit').addEventListener('submit', () => {
                        document.getElementById('content-edit').value = editor.getData();
                    });
                })
                .catch(error => console.error(error));
        });
    </script>
@endsection
