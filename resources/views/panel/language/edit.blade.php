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
                        <form action="{{route('language.update',$language->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="nameInput">زبان برنامه نویسی<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="nameInput" value="{{old('name',$language->name)}}">
                                        @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="slugInput">اسلاگ<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="slugInput" readonly value="{{old('slug',$language->slug)}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="inputColor1">رنگ 1<span class="text-danger">*</span></label>
                                    <div class="form-group mb-0">
                                        <input type="color" class="color-circle" name="primary_color" id="inputColor1" value="{{ old('primary_color', $language->primary_color ?? '#0080ff')}}">

                                        @error('primary_color')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="inputColor2">رنگ 2</label>
                                    <div class="form-group mb-0">
                                        <input type="color" class="color-circle" name="secondary_color" id="inputColor2" value="{{  old('secondary_color', $language->secondary_color ?? '#0000ff')}}">

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
@endsection
