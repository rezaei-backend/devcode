@extends('panel.layouts.master')
@section('title', 'درباره ما')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">

                <div class="card m-b-30 shadow-sm">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">درباره ما</h5>
                            </div>
                            <div class="col-6 text-left">
                                <a href="{{ route('aboutus.edit') }}" class="btn btn-primary-rgba">
                                    <i class="feather icon-edit-2 mr-1"></i> ویرایش درباره ما
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        @if(session('status'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="feather icon-check-circle"></i> {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </div>
                        @endif

                        @if(!$about->title && !$about->content && !$about->image)
                            <div class="text-center py-5">
                                <p class="text-muted">صفحه درباره ما هنوز تنظیم نشده است.</p>
                                <a href="{{ route('aboutus.edit') }}" class="btn btn-primary-rgba">
                                    تنظیم صفحه درباره ما
                                </a>
                            </div>
                        @else

                            <div class="table-responsive">
                                <table class="table table-borderless">

                                    <tbody>
                                    <tr style="border-bottom: 1px solid #ebebeb;">
                                        <th width="200">عنوان صفحه:</th>
                                        <td>
                                            {{ $about->title ?: '—' }}
                                        </td>
                                    </tr>

                                    <tr style="border-bottom: 1px solid #ebebeb;">
                                        <th>محتوا:</th>
                                        <td>
                                            @if($about->content)
                                                {!! Str::limit(strip_tags($about->content), 200) !!}
                                                @if(strlen(strip_tags($about->content)) > 200)
                                                    <a href="{{ route('aboutus.edit') }}" class="text-primary small"> ... ادامه متن</a>
                                                @endif
                                            @else
                                                <span class="text-muted">محتوایی وارد نشده است</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr style="border-bottom: 1px solid #ebebeb;">
                                        <th>تصویر فعلی:</th>
                                        <td>
                                            @if($about->image)
                                                <img src="{{ asset('images/about/' . $about->image) }}"
                                                     class="rounded shadow-sm"
                                                     style="max-height: 100px; object-fit: cover;">
                                            @else
                                                <span class="text-muted">تصویری انتخاب نشده</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>آخرین بروزرسانی:</th>
                                        <td>
                                            <strong>
                                                @if($about->updated_at)
                                                    {{ datejallali($about->updated_at, true) }}
                                                @else
                                                    نامشخص
                                                @endif
                                            </strong>
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
