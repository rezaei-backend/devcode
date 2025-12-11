@extends('panel.layouts.master')
@section('title', 'سوالات آزمون: ' . $quiz->title)

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">سوالات آزمون: {{ $quiz->title }}</h5>
                        <a href="{{ route('question.create', $quiz->id) }}" class="btn btn-primary-rgba">
                            افزودن سوال جدید
                        </a>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($questions->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">هنوز سوالی برای این آزمون ثبت نشده است.</p>
                                <a href="{{ route('question.create', $quiz->id) }}" class="btn btn-primary-rgba">ایجاد اولین سوال</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle">
                                    <thead>
                                    <tr style="border-bottom: 2px solid #eee;">
                                        <th>#</th>
                                        <th>متن سوال</th>
                                        <th>گزینه درست</th>
                                        <th>سختی</th>
                                        <th>وضعیت</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($questions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div style="max-width: 400px;" class="text-truncate" title="{{ strip_tags($question->question_text) }}">
                                                    {{ Str::limit(strip_tags($question->question_text), 80) }}
                                                </div>
                                            </td>
                                            <td>
                                                    <span class="badge badge-success">
                                                        {{ $question->options->firstWhere('is_correct', 1)->option_text ?? '—' }}
                                                    </span>
                                            </td>
                                            <td>
                                                    <span class="badge badge-{{ $question->difficulty == 'easy' ? 'success' : ($question->difficulty == 'medium' ? 'warning' : 'danger') }}">
                                                        {{ $question->difficulty == 'easy' ? 'آسان' : ($question->difficulty == 'medium' ? 'متوسط' : 'سخت') }}
                                                    </span>
                                            </td>
                                            <td>
                                                    <span class="badge badge-{{ $question->is_active ? 'primary' : 'secondary' }}">
                                                        {{ $question->is_active ? 'فعال' : 'غیرفعال' }}
                                                    </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('question.edit', [$quiz->id, $question->id]) }}"
                                                   class="btn btn-warning-rgba btn-sm">ویرایش</a>

                                                <form action="{{ route('question.destroy', [$quiz->id, $question->id]) }}"
                                                      method="POST" style="display: inline;"
                                                      onsubmit="return confirm('آیا از حذف این سوال مطمئن هستید؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-rgba btn-sm ms-1">حذف</button>
                                                </form>
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
