@extends('panel.layouts.master')

@section('title', 'ویرایش عضو تیم: {{ $team->fullname }}')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ویرایش عضو تیم: {{ $team->fullname }}</h5>
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

                        <form action="{{ route('team.update', $team->id) }}" method="POST" enctype="multipart/form-data" id="team-form-edit">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="remove_image" id="remove_image" value="0">

                            <!-- نام کامل و تخصص -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="fullname" class="font-weight-bold">نام کامل <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm @error('fullname') is-invalid @enderror"
                                           id="fullname" name="fullname" value="{{ old('fullname', $team->fullname) }}" required>
                                    @error('fullname')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="Expertise" class="font-weight-bold">تخصص <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm @error('Expertise') is-invalid @enderror"
                                           id="Expertise" name="Expertise" value="{{ old('Expertise', $team->Expertise) }}" required>
                                    @error('Expertise')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- ایمیل و شماره -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="font-weight-bold">ایمیل <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $team->email) }}" required>
                                    @error('email')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="font-weight-bold">شماره (اختیاری)</label>
                                    <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone', $team->phone) }}">
                                    @error('phone')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- رزومه -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="resume" class="font-weight-bold">رزومه (اختیاری)</label>
                                    <textarea class="form-control form-control-sm @error('resume') is-invalid @enderror"
                                              id="resume" name="resume" rows="3">{{ old('resume', $team->resume) }}</textarea>
                                    @error('resume')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- فقط نمایش عکس فعلی + امکان آپلود جدید -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    @if ($team->image)
                                        <div class="current-image-box p-3 border rounded bg-light mb-3">
                                            <label class="font-weight-bold d-block mb-2">عکس فعلی</label>
                                            <div class="text-center">
                                                <img src="{{ asset('images/team/' . $team->image) }}" class="img-thumbnail" style="max-height:180px;">
                                            </div>
                                        </div>
                                    @endif

                                    <label class="font-weight-bold">عکس جدید (برای جایگزینی عکس فعلی)</label>
                                    <div class="image-upload-container" id="image-upload-edit">
                                        <input type="file" id="image-input-edit" name="image" accept="image/*" hidden>
                                        <div class="drop-zone" id="drop-zone-edit">
                                            <p class="drop-text">فایل را بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                            <div id="image-preview-edit" class="image-preview mt-2"></div>
                                        </div>
                                    </div>
                                    <small class="text-muted">در صورت آپلود تصویر جدید، تصویر قبلی به صورت خودکار جایگزین می‌شود.</small>
                                    @error('image') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary-rgba px-5 py-2">ذخیره تغییرات</button>
                                <a href="{{ route('team.index') }}" class="btn btn-outline-secondary px-5 py-2 ms-2">لغو</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .drop-zone { border: 2px dashed #ccc; border-radius: .5rem; padding: 2rem; text-align: center; background: #fafafa; transition: .3s; cursor: pointer; }
        .drop-zone.dragover { border-color: #1976d2; background: #e3f2fd; }
        .image-preview img { max-height: 180px; border-radius: .375rem; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropZoneEdit = document.getElementById('drop-zone-edit');
            const inputEdit = document.getElementById('image-input-edit');
            const previewEdit = document.getElementById('image-preview-edit');

            dropZoneEdit.addEventListener('click', () => inputEdit.click());
            inputEdit.addEventListener('change', () => inputEdit.files[0] && showPreview(inputEdit.files[0], previewEdit));

            ['dragover', 'dragenter'].forEach(e => dropZoneEdit.addEventListener(e, ev => { ev.preventDefault(); dropZoneEdit.classList.add('dragover'); }));
            ['dragleave', 'dragend'].forEach(e => dropZoneEdit.addEventListener(e, () => dropZoneEdit.classList.remove('dragover')));
            dropZoneEdit.addEventListener('drop', e => {
                e.preventDefault();
                dropZoneEdit.classList.remove('dragover');
                if (e.dataTransfer.files[0]?.type.startsWith('image/')) {
                    inputEdit.files = e.dataTransfer.files;
                    showPreview(e.dataTransfer.files[0], previewEdit);
                }
            });

            function showPreview(file, el) {
                const reader = new FileReader();
                reader.onload = e => el.innerHTML = `<img src="${e.target.result}" alt="پیش‌نمایش">`;
                reader.readAsDataURL(file);
            }
        });

    </script>
@endsection
