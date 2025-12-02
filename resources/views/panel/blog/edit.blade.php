@extends('Panel.Layouts.master')
@section('title', 'ویرایش مقاله: ' . Str::limit($blog->title, 40))

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ویرایش مقاله: {{ Str::limit($blog->title, 60) }}</h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="post-form-edit">
                            @csrf @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="font-weight-bold">عنوان</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $blog->title) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold">دسته‌بندی</label>
                                    <select class="form-control" name="category_id" required>
                                        <option value="">انتخاب کنید</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id', $blog->category_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- تصویر فعلی + حذف -->
                            @if($blog->image)
                                <div class="current-image-box p-3 border rounded bg-light mb-3">
                                    <label class="font-weight-bold d-block mb-2">تصویر فعلی</label>
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('images/blog/' . $blog->image) }}" class="img-thumbnail" style="max-height:180px;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 mt-2 me-2"
                                                onclick="removeCurrentImage()">
                                            حذف
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="remove_image" id="remove_image" value="0">
                            @endif

                            <!-- تصویر جدید -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">تصویر جدید (اختیاری)</label>
                                    <div class="image-upload-container">
                                        <input type="file" id="image-input-edit" name="image" accept="image/*" hidden>
                                        <div class="drop-zone" id="drop-zone-edit">
                                            <p class="drop-text">فایل را بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                            <div id="image-preview-edit" class="image-preview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">محتوا</label>
                                    <div id="editor-edit">{!! old('content', $blog->content) !!}</div>
                                    <input type="hidden" name="content" id="content-edit">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">تگ‌ها</label>
                                    <input type="hidden" name="tags" id="selected_tags"
                                           value="{{ old('tags', $blog->tags->pluck('name')->implode('|')) }}">
                                    <div class="tag-input-container">
                                        <div id="tag-chips" class="selected-tags"></div>
                                        <input type="text" id="tag-search" class="border-0 outline-0 w-100" placeholder="تایپ کنید و Enter بزنید..." autocomplete="off">
                                    </div>
                                    <div id="tag-list" class="tag-list mt-2"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">متا تایتل</label>
                                    <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">متا توضیحات</label>
                                    <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-success btn-lg px-5">ذخیره تغییرات</button>
                                <a href="{{ route('blog.index') }}" class="btn btn-secondary btn-lg px-5 ms-2">لغو</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function removeCurrentImage() {
            document.getElementById('remove_image').value = '1';
            document.querySelector('.current-image-box').style.opacity = '0.5';
            document.querySelector('.current-image-box img').style.filter = 'grayscale(100%)';
        }
    </script>

    @include('panel.blog.partials.scripts')
@endsection
