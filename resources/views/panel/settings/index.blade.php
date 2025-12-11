@extends('panel.layouts.master')
@section('title', 'تنظیمات سایت')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">

                <div class="card m-b-30 shadow-sm">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">تنظیمات سایت</h5>
                            </div>
                            <div class="col-6 text-left">
                                <a href="{{ route('settings.edit') }}" class="btn btn-primary-rgba">
                                    ویرایش تنظیمات
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(!$setting)
                            <div class="text-center py-5">
                                <p class="text-muted">هنوز تنظیماتی ثبت نشده است.</p>
                                <a href="{{ route('settings.edit') }}" class="btn btn-primary-rgba">
                                    تنظیمات اولیه
                                </a>
                            </div>
                        @else

                            <div class="table-responsive">
                                <table class="table table-borderless">

                                    <tbody>
                                    <tr style="border-bottom: 1px solid #ebebeb;">
                                        <th width="200">نام سایت:</th>
                                        <td>{{ $setting->site_name }}</td>
                                    </tr>

                                    <tr style="border-bottom: 1px solid #ebebeb;">
                                        <th>زبان پیش‌فرض:</th>
                                        <td>
                                        <span class="badge badge-info px-2 py-1">
                                            {{ strtoupper($setting->default_language) }}
                                        </span>
                                        </td>
                                    </tr>

                                    <tr style="border-bottom: 1px solid #ebebeb;">
                                        <th>ایمیل تماس:</th>
                                        <td>{{ $setting->contact_email ?: '—' }}</td>
                                    </tr>

                                    <tr style="border-bottom: 1px solid #ebebeb;">
                                        <th>توضیحات متا:</th>
                                        <td>{{ Str::limit($setting->meta_description, 100) }}</td>
                                    </tr>

                                    <tr>
                                        <th>لوگوی فعلی:</th>
                                        <td>
                                            @if($setting->logo_path)
                                                <img src="{{ asset('images/settings/' . $setting->logo_path) }}"
                                                     class="rounded shadow-sm"
                                                     style="max-height: 80px;">
                                            @else
                                                <span class="text-muted">تنظیم نشده</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>فاوآیکون:</th>
                                        <td>
                                            @if($setting->favicon_path)
                                                <img src="{{ asset('images/settings/' . $setting->favicon_path) }}"
                                                     class="rounded shadow-sm"
                                                     style="height: 40px;">
                                            @else
                                                <span class="text-muted">تنظیم نشده</span>
                                            @endif
                                        </td>
                                    </tr>

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
