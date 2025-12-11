@extends('panel.layouts.master')
@section('title', 'ارتباط با ما')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">

                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">پیام‌های ارتباط با ما</h5>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        @if($messages->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">هیچ پیامی ثبت نشده است.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                    <tr style="border-bottom: 1px solid #ebebeb;">
                                        <th>#</th>
                                        <th>پیام</th>
                                        <th>شماره تماس</th>
                                        <th>ایمیل</th>
                                        <th>تاریخ</th>
                                        <th>وضعیت</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($messages as $msg)
                                        <tr>
                                            <td>{{ $msg->id }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($msg->message, 10) }}</td>
                                            <td>{{ $msg->phone }}</td>
                                            <td>{{ $msg->email }}</td>
                                            <td>{{ datejallali($msg->created_at, 1) }}</td>
                                            <td>
                                                <form action="{{ route('contactus.toggleStatus', $msg->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn {{ $msg->status ? 'btn-success' : 'btn-secondary' }} px-4 py-2">
                                                        {{ $msg->status ? 'خوانده شده' : 'خوانده نشده' }}
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('contactus.show', $msg->id) }}"
                                                   class="btn btn-primary-rgba btn-sm" title="مشاهده">
                                                    <i class="feather icon-external-link"></i>
                                                </a>
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
