@extends('panel.layouts.master')
@section('title', 'مدیریت زبان‌های برنامه‌نویسی')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">زبان‌های برنامه‌نویسی</h5>
                            </div>
                            <div class="col-6 text-left">
                                <a href="{{ route('language.create') }}" class="btn btn-primary-rgba">
                                    ایجاد زبان جدید
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                                                    @if ($languages->isEmpty())
                                                        <div class="text-center py-5">
                                                            <p class="text-muted">هیچ زبانی ایجاد نشده است.</p>
                                                            <a href="{{ route('language.create') }}" class="btn btn-primary-rgba">ایجاد اولین زبان</a>
                                                        </div>
                                                    @else
                                                        <div class="table-responsive">
                                                            <table class="table table-borderless">
                                                                <thead>
                                                                    <tr style="border-bottom: 1px solid #ebebeb;">
                                                                        <th>#</th>
                                                                        <th>لوگو</th>
                                                                        <th>نام زبان</th>
                                                                        <th>اسلاگ</th>
                                                                        <th>رنگ اصلی</th>
                                                                        <th>رنگ ثانویه</th>
                                                                        <th class="text-center">عملیات</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($languages as $index => $lang)
                                                                        <tr>
                                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                                            <td>
                                                                                @if ($lang->logo)
                                                                                    <img src="{{ asset('images/language/' . $lang->logo) }}"
                                                                                         alt="{{ $lang->name }}" class="rounded" style="width: 60px; height: 60px; object-fit: contain; background: #f8f9fa;">
                                                                                @else
                                                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                                                        <i class="feather icon-code text-muted"></i>
                                                                                    </div>
                                                                                @endif
                                                                            </td>
{{--                                                                            <td>{{ $lang->name }}</td>--}}
{{--                                                                            <td>{{ $lang->display_name }}</td>--}}
                                                                            <td>{{ display_language_name($lang->name) }}</td>

                                                                            <td><code>{{ $lang->slug }}</code></td>
                                                                            <td>
                                                                                <span class="badge text-white px-3 py-2" style="background-color: {{ $lang->primary_color }};">
                                                                                    {{ $lang->primary_color }}
                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                <span class="badge text-white px-3 py-2" style="background-color: {{ $lang->secondary_color ?? '#666' }};">
                                                                                    {{ $lang->secondary_color ?? '—' }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <div class="button-list">
                                                                                    <a href="{{ route('language.edit', $lang->slug) }}"
                                                                                       class="btn btn-success-rgba btn-sm" title="ویرایش">
                                                                                        <i class="feather icon-edit-2"></i>
                                                                                    </a>
                                                                                    <form action="{{ route('language.destroy', $lang->id) }}" method="POST" style="display:inline;">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit" class="btn btn-danger-rgba btn-sm" title="حذف"
                                                                                                onclick="return confirm('آیا از حذف زبان «{{ $lang->name }}» مطمئن هستید؟')">
                                                                                            <i class="feather icon-trash-2"></i>
                                                                                        </button>
                                                                                    </form>

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

@endsection
