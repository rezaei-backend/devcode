@extends('Panel.Layouts.master')
@section('title', 'ایجاد مقاله جدید')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ایجاد مقاله جدید</h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" id="post-form">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="font-weight-bold">عنوان مقاله <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="title" value="{{ old('title') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold">دسته‌بندی <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm" name="category_id" required>
                                        <option value="">انتخاب کنید</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- تصویر -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">تصویر مقاله (اختیاری)</label>
                                    <div class="image-upload-container">
                                        <input type="file" id="image-input-create" name="image" accept="image/*" hidden>
                                        <div class="drop-zone" id="drop-zone-create">
                                            <p class="drop-text">فایل را بکشید یا <span class="text-primary" style="cursor:pointer;text-decoration:underline;">انتخاب کنید</span></p>
                                            <div id="image-preview-create" class="image-preview"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- محتوا -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">محتوای مقاله <span class="text-danger">*</span></label>
                                    <div id="editor-create">{!! old('content') !!}</div>
                                    <input type="hidden" name="content" id="content-create">
                                </div>
                            </div>

                            <!-- تگ‌ها -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-weight-bold">تگ‌ها</label>
                                    <input type="hidden" name="tags" id="selected_tags" value="{{ old('tags') }}">
                                    <div class="tag-input-container">
                                        <div id="tag-chips" class="selected-tags"></div>
                                        <input type="text" id="tag-search" class="border-0 outline-0 w-100" placeholder="تایپ کنید و Enter بزنید..." autocomplete="off">
                                    </div>
                                    <div id="tag-list" class="tag-list mt-2"></div>
                                    <small class="text-muted d-block mt-2">تگ جدید هم می‌تونه ایجاد کنه</small>
                                </div>
                            </div>

                            <!-- متا -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">متا تایتل</label>
                                    <input type="text" class="form-control form-control-sm" name="meta_title" value="{{ old('meta_title') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">متا توضیحات</label>
                                    <textarea class="form-control form-control-sm" name="meta_description" rows="2">{{ old('meta_description') }}</textarea>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary btn-lg px-5">ایجاد مقاله</button>
                                <a href="{{ route('blog.index') }}" class="btn btn-secondary btn-lg px-5 ms-2">لغو</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('panel.blog.partials.scripts')
@endsection
