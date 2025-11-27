@extends('panel.layouts.master')

@section('title')
    درباره ما
@endsection

@section('content')

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show col-4 m-auto" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger p-2">
            <ul style="margin:0; padding-left:15px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid my-4 pb-5">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header pb-0">
                    <h5>درباره ما</h5>
                </div>
                <form class="form theme-form" method="post" action="{{ route('about.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label" for="titleInput">عنوان</label>
                                <input class="form-control input-air-primary" name="title" id="titleInput" type="text" value="{{ old('title', $about->title ?? '') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label" for="contentTextarea">توضیحات</label>
                                <textarea class="form-control input-air-primary" id="contentTextarea" name="content" rows="5">{{ old('content', $about->content ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label" for="imageInput">تصویر</label>
                                <input class="form-control input-air-primary" name="image" id="imageInput" type="file">
                                @if(!empty($about->image))
                                    <div class="mt-2">
                                        <img src="{{ asset('images/about/' . $about->image) }}" width="100" class="img-thumbnail">
                                    </div>
                                    <!-- تیک حذف تصویر اضافه شد -->
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="remove_image" id="removeImage" value="1">
                                        <label class="form-check-label" for="removeImage">
                                            حذف تصویر فعلی
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary mt-3" type="submit">ثبت</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
