@extends('panel.layouts.master')
@section('title','لیست آزمون‌ها')

<!-- پیام فلش -->
@if (session('success'))
    <div class="alert alert-success p-[12px]" id="success-alert">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger p-[12px]" id="error-alert">{{ session('error') }}</div>
@endif

@section('content')
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">آزمون‌ها</h5>
                        <a class="btn btn-outline-primary" href="{{ route('quiz.create') }}">ایجاد آزمون جدید</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table foo-basic-table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>عنوان آزمون</th>
                                    <th>زبان برنامه نویسی</th>
                                    <th>توضیحات</th>
                                    <th>مدت زمان (دقیقه)</th>
                                    <th>ویرایش</th>
                                    <th>حذف</th>

                                </tr>
                                </thead>
                                <tbody>
                                @forelse($quizzes as $quiz)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('question.index', $quiz->id) }}">
                                                {{ $quiz->title }}
                                            </a>
                                        </td>

                                        <td>{{ $quiz->language->name ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($quiz->description, 20, '...') }}</td>
                                        <td>{{ $quiz->duration_minutes }}</td>
                                        <td>
                                            <a href="{{ route('quiz.edit', $quiz->id) }}" class="btn btn-round btn-warning" title="ویرایش">
                                                <i class="feather icon-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-round btn-danger mt-1 model-animation-btn" data-toggle="modal" data-target="#deleteModalCenter{{ $quiz->id }}" title="حذف">
                                                <i class="feather icon-trash-2"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <a href="{{ route('question.create', $quiz->id) }}" class="btn btn-success btn-sm">
                                                اضافه کردن سوال
                                            </a>
                                        </td>

                                    </tr>

                                    <!-- Modal حذف -->
                                    <div class="modal fade" id="deleteModalCenter{{ $quiz->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">حذف آزمون</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    آیا مطمئن هستید که می‌خواهید این آزمون را حذف کنید؟
                                                    <form action="{{ route('quiz.destroy', $quiz->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                                                            <button type="submit" class="btn btn-danger">حذف</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">هیچ آزمونی وجود ندارد</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{ $quizzes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End row -->
    </div>
@endsection
