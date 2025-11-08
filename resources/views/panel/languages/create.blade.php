@extends('panel.layouts.master')

@section('title', 'افزودن زبان')

@section('content')
    <div class="card mt-4 shadow-sm">

        <div class="card-body">
            {{-- پیام موفقیت --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- خطاهای اعتبارسنجی --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('languages.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="name">نام زبان:</label>
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="مثلاً PHP یا Python"
                           required>
                </div>

                <div class="form-group mb-3">
                    <label for="slug">نام کوتاه (slug):</label>
                    <input type="text"
                           name="slug"
                           id="slug"
                           class="form-control @error('slug') is-invalid @enderror"
                           value="{{ old('slug') }}"
                           placeholder="مثلاً php یا python"
                           required>
                </div>

                <div class="form-group mb-3">
                    <label for="primary_color">رنگ اصلی:</label>
                    <input type="color"
                           name="primary_color"
                           id="primary_color"
                           class="form-control form-control-color"
                           required>
                </div>

                <div class="form-group mb-4">
                    <label for="secondary_color">رنگ فرعی (اختیاری):</label>
                    <input type="color"
                           name="secondary_color"
                           id="secondary_color"
                           class="form-control form-control-color">
                </div>

                <button type="submit" class="btn btn-success px-4">افزودن</button>
                <a href="{{ route('languages.index') }}" class="btn btn-secondary">بازگشت</a>
            </form>
        </div>
    </div>
@endsection
