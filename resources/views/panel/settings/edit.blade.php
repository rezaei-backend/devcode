@extends('panel.layouts.master')
@section('title', 'ویرایش تنظیمات سایت')
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ویرایش تنظیمات سایت</h5>
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

                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- اطلاعات عمومی -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">نام سایت <span class="text-danger">*</span></label>
                                    <input type="text" name="site_name" class="form-control"
                                           value="{{ old('site_name', $setting->site_name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="font-weight-bold">زبان پیش‌فرض <span class="text-danger">*</span></label>
                                    <select name="default_language" class="form-control" required>
                                        <option value="fa" {{ old('default_language', $setting->default_language) == 'fa' ? 'selected' : '' }}>فارسی</option>
                                        <option value="en" {{ old('default_language', $setting->default_language) == 'en' ? 'selected' : '' }}>English</option>
                                        <option value="ar" {{ old('default_language', $setting->default_language) == 'ar' ? 'selected' : '' }}>العربية</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="font-weight-bold">ایمیل تماس</label>
                                <input type="email" name="contact_email" class="form-control"
                                       value="{{ old('contact_email', $setting->contact_email) }}">
                            </div>

                            <div class="mb-4">
                                <label class="font-weight-bold">توضیحات متا (Meta Description)</label>
                                <textarea name="meta_description" class="form-control" rows="4">{{ old('meta_description', $setting->meta_description) }}</textarea>
                            </div>

                            <hr>

                            <div class="row mb-3">

                                <!-- لوگو سایت -->
                                <div class="col-md-6">
                                    <label class="font-weight-bold">لوگو سایت</label>

                                    <!-- چک‌باکس حذف لوگو - همیشه در فرم می‌ماند -->
                                    <input type="hidden" name="remove_logo" value="0">
                                    <input type="checkbox" name="remove_logo" id="remove_logo" value="1" class="d-none">

                                    @if ($setting->logo_path)
                                        <div class="current-image-box p-3 border rounded bg-light mb-3" id="current-logo-box">
                                            <label class="font-weight-bold d-block mb-2">لوگوی فعلی</label>
                                            <div class="text-center position-relative d-inline-block">
                                                <img src="{{ asset('images/settings/' . $setting->logo_path) }}" class="img-thumbnail" style="max-height:150px;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 mt-2 me-2"
                                                        onclick="removeCurrentImage('current-logo-box', 'remove_logo')">
                                                    <i class="fas fa-trash-alt"></i> حذف
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="image-upload-container">
                                        <input type="file" id="logo-input" name="logo" accept="image/*" hidden>
                                        <div class="drop-zone" id="logo-drop-zone">
                                            <p class="drop-text">فایل را اینجا بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                            <div id="logo-preview" class="image-preview mt-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- فاوآیکون -->
                                <div class="col-md-6">
                                    <label class="font-weight-bold">فاوآیکون</label>

                                    <!-- چک‌باکس حذف فاوآیکون -->
                                    <input type="hidden" name="remove_favicon" value="0">
                                    <input type="checkbox" name="remove_favicon" id="remove_favicon" value="1" class="d-none">

                                    @if ($setting->favicon_path)
                                        <div class="current-image-box p-3 border rounded bg-light mb-3" id="current-favicon-box">
                                            <label class="font-weight-bold d-block mb-2">فاوآیکون فعلی</label>
                                            <div class="text-center position-relative d-inline-block">
                                                <img src="{{ asset('images/settings/' . $setting->favicon_path) }}" class="img-thumbnail" style="max-height:100px;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 mt-2 me-2"
                                                        onclick="removeCurrentImage('current-favicon-box', 'remove_favicon')">
                                                    <i class="fas fa-trash-alt"></i> حذف
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="image-upload-container">
                                        <input type="file" id="favicon-input" name="favicon" accept="image/*" hidden>
                                        <div class="drop-zone" id="favicon-drop-zone">
                                            <p class="drop-text">فایل را اینجا بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                            <div id="favicon-preview" class="image-preview mt-2"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-success-rgba px-5 py-2">ذخیره تنظیمات</button>
                                <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary px-5 py-2 ms-3">بازگشت</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .current-image-box { background:#f8f9fa; border:1px solid #dee2e6; }
        .drop-zone { border:2px dashed #ccc; padding:2rem; border-radius:.5rem; text-align:center; background:#fafafa; cursor:pointer; transition:0.3s; }
        .drop-zone.dragover { border-color:#1976d2; background:#e3f2fd; }
        .drop-text { margin:0; color:#666; font-size:.95rem; }
        .image-preview img { max-height:150px; border-radius:.375rem; margin-top:.5rem; }
    </style>

    <script>
        // تابع حذف تصویر فعلی (فقط باکس رو حذف می‌کنه و چک‌باکس رو تیک می‌زنه)
        function removeCurrentImage(boxId, checkboxId) {
            const box = document.getElementById(boxId);
            if (box) box.remove();

            const checkbox = document.getElementById(checkboxId);
            if (checkbox) checkbox.checked = true;
        }

        // آپلودر درگ اند دراپ
        function initUploader(dropId, inputId, previewId) {
            const drop = document.getElementById(dropId);
            const fileInput = document.getElementById(inputId);
            const preview = document.getElementById(previewId);

            drop.addEventListener('click', () => fileInput.click());

            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) showPreview(this.files[0], preview);
            });

            ['dragover', 'dragenter'].forEach(ev => drop.addEventListener(ev, e => {
                e.preventDefault();
                drop.classList.add('dragover');
            }));

            ['dragleave', 'drop'].forEach(ev => drop.addEventListener(ev, e => {
                e.preventDefault();
                drop.classList.remove('dragover');
            }));

            drop.addEventListener('drop', e => {
                e.preventDefault();
                const files = e.dataTransfer.files;
                if (files.length > 0 && files[0].type.startsWith('image/')) {
                    fileInput.files = files;
                    showPreview(files[0], preview);
                }
            });

            function showPreview(file, previewElement) {
                const reader = new FileReader();
                reader.onload = e => previewElement.innerHTML = `<img src="${e.target.result}">`;
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            initUploader('logo-drop-zone', 'logo-input', 'logo-preview');
            initUploader('favicon-drop-zone', 'favicon-input', 'favicon-preview');
        });
    </script>
@endsection
