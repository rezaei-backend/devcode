@extends('Panel.Layouts.master')
@section('title', 'ویرایش دسته‌بندی: ' . $category->name)

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">ویرایش دسته‌بندی: {{ $category->name }}</h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('category.update', $category->id) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <label class="font-weight-bold">نام دسته‌بندی <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name', $category->name) }}" required>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-success px-5 py-2">ذخیره تغییرات</button>
                                <a href="{{ route('category.index') }}" class="btn btn-outline-secondary px-5 py-2 ms-2">لغو</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
