@extends('panel.layouts.master')

@section('title', 'ایجاد عضو تیم جدید')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ایجاد عضو تیم جدید</h5>
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

                        <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data" id="team-form">
                            @csrf

                            <!-- نام کامل و تخصص -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="fullname" class="font-weight-bold">نام کامل <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm @error('fullname') is-invalid @enderror"
                                           id="fullname" name="fullname" value="{{ old('fullname') }}" required>
                                    @error('fullname')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="Expertise" class="font-weight-bold">تخصص <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm @error('Expertise') is-invalid @enderror"
                                           id="Expertise" name="Expertise" value="{{ old('Expertise') }}" required>
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
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="font-weight-bold">شماره (اختیاری)</label>
                                    <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone') }}">
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
                                              id="resume" name="resume" rows="3">{{ old('resume') }}</textarea>
                                    @error('resume')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- عکس با Drag & Drop -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">عکس فرد <span class="text-danger">*</span></label>
                                    <div class="image-upload-container" id="image-upload-create">
                                        <input type="file" id="image-input-create" name="image" accept="image/*" hidden>
                                        <div class="drop-zone" id="drop-zone-create">
                                            <p class="drop-text">فایل را اینجا بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                            <div id="image-preview-create" class="image-preview mt-2"></div>
                                        </div>
                                    </div>
                                    <small class="text-muted">حداکثر ۲ مگابایت - jpg, png, gif, svg</small>
                                    @error('image')
                                    <span class="text-danger mt-2 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary-rgba px-5 py-2">ایجاد عضو تیم</button>
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
            const dropZoneCreate = document.getElementById('drop-zone-create');
            const inputCreate = document.getElementById('image-input-create');
            const previewCreate = document.getElementById('image-preview-create');

            dropZoneCreate.addEventListener('click', () => inputCreate.click());
            inputCreate.addEventListener('change', () => inputCreate.files[0] && showPreview(inputCreate.files[0], previewCreate));

            ['dragover', 'dragenter'].forEach(e => dropZoneCreate.addEventListener(e, ev => { ev.preventDefault(); dropZoneCreate.classList.add('dragover'); }));
            ['dragleave', 'dragend'].forEach(e => dropZoneCreate.addEventListener(e, () => dropZoneCreate.classList.remove('dragover')));
            dropZoneCreate.addEventListener('drop', e => {
                e.preventDefault();
                dropZoneCreate.classList.remove('dragover');
                if (e.dataTransfer.files[0]?.type.startsWith('image/')) {
                    inputCreate.files = e.dataTransfer.files;
                    showPreview(e.dataTransfer.files[0], previewCreate);
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
