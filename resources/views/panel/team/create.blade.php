

@extends('panel.layouts.master')

@section('title', 'تیم ما')

@section('content')


    <form action="{{route('team.store')}}" method="post" enctype="multipart/form-data">
        @csrf


        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <div class="col-lg-12">
                            @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{$error }}
                            </div>
                        @endforeach

                    @endif
                </div>
                                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">نام کامل</h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group mb-0">
                                <input type="text" class="form-control" name="fullname" id="inputText" value="{{old('fullname')}}" placeholder="نام فرد مورد نظر را وارد کنید">
                            </div>
                        </div>
                    </div>
                </div>









            <div class="col-lg-6">
            <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">تخصص</h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group mb-0">
                                <input type="text" class="form-control" name="Expertise" id="inputText" value="{{old('Expertise')}}" placeholder="تخصص فرد مورد نظر را وارد کنید">
                            </div>
                        </div>
                    </div>
            </div>




            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">email</h5>
                    </div>
                    <div class="card-body">

                        <div class="form-group mb-0">
                            <input type="text" class="form-control" name="email" id="inputText" value="{{old('email')}}" placeholder="ایمیل فرد مورد نظر را وارد کنید">
                        </div>
                    </div>
                </div>
            </div>






                <div class="col-12">
                    <!-- Start col -->
                    <div class="card m-b-30">

                <!-- لوگو با Drag & Drop -->



                        <div class="card-header">
                            <h5 class="card-title">File upload</h5>
                        </div>
                        <div class="card-body">
                            <div class="fallback">

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="font-weight-bold">عکس فرد<span class="text-danger">*</span></label>
                                        <div class="image-upload-container" id="image-upload-create">
                                            <input type="file" id="image-input-create" name="image" accept="image/*" hidden>
                                            <div class="drop-zone" id="drop-zone-create">
                                                <p class="drop-text">فایل را اینجا بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                                <div id="image-preview-create" class="image-preview mt-2"></div>
                                            </div>
                                        </div>
                                        <small class="text-muted">حداکثر ۲ مگابایت - jpg, png, gif, svg</small>

                                    </div>
                                </div>
                            </div>
                            <div class="text-center m-t-15">
                                <button type="submit" class="btn btn-primary">ثبت</button>
                            </div>
                        </div>
                    </div>
                </div>









        </div>
        </div>

    </form>


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
