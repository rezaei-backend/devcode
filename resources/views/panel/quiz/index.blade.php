@extends('panel.layouts.master')
@section('title', 'مدیریت آزمون‌ها')
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">آزمون‌ها</h5>
                        <a href="{{ route('quiz.create') }}" class="btn btn-primary-rgba">
                            ایجاد آزمون جدید
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if($quizzes->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">هنوز آزمونی ایجاد نشده است.</p>
                                <a href="{{ route('quiz.create') }}" class="btn btn-primary-rgba">ایجاد اولین آزمون</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle">
                                    <thead>
                                    <tr style="border-bottom: 2px solid #eee;">
                                        <th>#</th>
                                        <th>عنوان آزمون</th>
                                        <th>زبان</th>
                                        <th>تعداد سوالات</th>
                                        <th>مدت زمان</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($quizzes as $quiz)
                                        <tr>
                                            <td>{{ $loop->iteration + ($quizzes->currentPage() - 1) * $quizzes->perPage() }}</td>
                                            <td>
                                                <a href="{{ route('question.index', $quiz->id) }}" class="text-primary font-weight-bold">
                                                    {{ $quiz->title }}
                                                </a>
                                            </td>
                                            <td>
                                                    <span class="badge badge-info">
                                                        {{ $quiz->language->name ?? 'نامشخص' }}
                                                    </span>
                                            </td>
                                            <td>
                                                    <span class="badge badge-secondary">
                                                        {{ $quiz->questions->count() }} سوال
                                                    </span>
                                            </td>
                                            <td>{{ $quiz->duration_minutes }} دقیقه</td>
                                            <td class="text-center">
                                                <div class="button-list">
                                                    <a href="{{ route('question.create', $quiz->id) }}"
                                                       class="btn btn-success-rgba btn-sm" title="افزودن سوال">
                                                        سوال
                                                    </a>
                                                    <a href="{{ route('quiz.edit', $quiz->id) }}"
                                                       class="btn btn-warning-rgba btn-sm" title="ویرایش">
                                                        ویرایش
                                                    </a>
                                                    <form action="{{ route('quiz.destroy', $quiz->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger-rgba btn-sm"
                                                                onclick="return confirm('هشدار: این آزمون و تمام سوالاتش حذف خواهد شد! مطمئن هستید؟')">
                                                            حذف
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $quizzes->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
