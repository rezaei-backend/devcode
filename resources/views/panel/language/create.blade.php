@extends('panel.layouts.master')
@section('title','زبان برنامه نویسی')

@section('content')
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">ویرایش زبان برنامه نویسی</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-subtitle"></h6>
                        <form action="{{route('language.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nameInput">زبان برنامه نویسی<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="nameInput" value="{{old('name')}}">
                                        @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="meta_descriptionInput">توضیحات متا<span class="text-danger">*</span></label>
                                        <textarea  class="form-control" id="meta_descriptionInput" name="meta_description">{{old('meta_description')}}</textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="descriptionInput">توضیحات<span class="text-danger">*</span></label>
                                        <textarea rows="10" class="form-control" id="descriptionInput" name="description">{{old('description')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="logo">لوگو<span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="logo" name="logo">
                                        <div id="logoContainer">
                                            <img src="" id="logoPreview" alt="پیش نمایش لوگو"  style="max-width:200px; max-height:100px; object-fit:cover; display:none;">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="inputColor1">رنگ 1<span class="text-danger">*</span></label>
                                    <div class="form-group">
                                        <input type="color" class="color-circle" name="primary_color" id="inputColor1" value="{{ old('primary_color') }}">
                                        @error('primary_color')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="inputColor2">رنگ 2</label>
                                    <div class="form-group">
                                        <input type="color" class="color-circle" name="secondary_color" id="inputColor2" value="{{ old('secondary_color') }}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">ویرایش</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End row -->
    </div>

    <style>
        .color-circle {
            -webkit-appearance: none;
            border: none;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            padding: 0;
            cursor: pointer;
            overflow: hidden;
        }

        .color-circle::-webkit-color-swatch-wrapper {
            padding: 0;
        }

        .color-circle::-webkit-color-swatch {
            border: none;
            border-radius: 50%;
        }

    </style>

    <script>
        // پیش‌نمایش تصویر لوگو
        document.getElementById('logo')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('logoPreview');
            const container = document.getElementById('logoContainer');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
                container.style.opacity = '1';
                preview.style.filter = 'none';
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });
    </script>
@endsection
