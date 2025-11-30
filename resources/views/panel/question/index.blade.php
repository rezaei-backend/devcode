@extends('panel.layouts.master')
@section('title','سوالات آزمون ' . $quiz->title)

@section('content')
    <div class="contentbar">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">سوالات آزمون: {{ $quiz->title }}</h5>

                <a href="{{ route('question.create', $quiz->id) }}" class="btn btn-primary">
                    افزودن سوال جدید
                </a>
            </div>

            <div class="card-body">

                @if($questions->isEmpty())
                    <p class="text-center">هیچ سوالی برای این آزمون ثبت نشده است.</p>
                @else

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>متن سوال</th>
                                <th>گزینه‌ها</th>
                                <th>گزینه درست</th>
                                <th>فعال؟</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($questions as $question)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ Str::limit($question->question_text, 40) }}</td>

                                    <td>
                                        <ul class="mb-0">
                                            @foreach($question->options as $index => $opt)
                                                <li>
                                                    {{ $opt->option_text }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    <td>
                                        {{ $question->options->firstWhere('is_correct', 1)->option_text ?? '---' }}
                                    </td>


                                    <td>
                                        <form action="{{ route('question.toggle', $question->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $question->is_active ? 'btn-success' : 'btn-danger' }}">
                                                {{ $question->is_active ? 'فعال' : 'غیرفعال' }}
                                            </button>
                                        </form>
                                    </td>


                                    <td>
                                        <a href="{{ route('question.edit', [$quiz->id, $question->id]) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="feather icon-edit"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <form action="{{ route('question.destroy', [$quiz->id, $question->id]) }}"
                                              method="POST"
                                              onsubmit="return confirm('حذف شود؟')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">
                                                <i class="feather icon-trash-2"></i>
                                            </button>
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
@endsection
