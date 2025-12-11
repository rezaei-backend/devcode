@extends('panel.layouts.master')
@section('title', 'مشاهده پیام')

@section('content')
    <div class="contentbar">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">

                <div class="card m-b-30 shadow-sm">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">جزئیات پیام</h5>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="mb-4">
                            <h6 class="text-muted mb-1">متن پیام</h6>
                            <p class="mb-0">{{ $message->message }}</p>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="text-muted mb-1">شماره تماس</h6>
                            <p class="mb-0">{{ $message->phone }}</p>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="text-muted mb-1">ایمیل</h6>
                            <p class="mb-0">{{ $message->email }}</p>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="text-muted mb-1">تاریخ ارسال</h6>
                            <p>{{ datejallali($message->created_at, 1) }}</p>
                        </div>

                        <hr>

                        <div class="mt-3">
                            <form action="{{ route('contactus.toggleStatus', $message->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit"
                                        class="btn {{ $message->status ? 'btn-success' : 'btn-secondary' }} px-4 py-2 me-2">
                                    {{ $message->status ? 'خوانده شده' : 'خوانده نشده' }}
                                </button>
                            </form>

                            <a href="{{ route('contactus.index') }}" class="btn btn-primary-rgba px-4 py-2">
                                بازگشت
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
