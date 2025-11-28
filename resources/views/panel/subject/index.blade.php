@extends('Panel.Layouts.master')
@section('title', 'مدیریت موضوعات')
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">موضوعات</h5>
                            </div>
                            <div class="col-6 text-left">
                                <a href="{{ route('subject.create') }}" class="btn btn-primary-rgba">
                                    ایجاد موضوع جدید
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($subjects->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">هیچ موضوعی ایجاد نشده است.</p>
                                <a href="{{ route('subject.create') }}" class="btn btn-primary-rgba">ایجاد اولین موضوع</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                    <tr style="border-bottom: 1px solid #ebebeb;">
                                        <th>#</th>
                                        <th>عنوان</th>
                                        <th>زبان</th>
                                        <th>توضیحات</th>
                                        <th>تاریخ ایجاد</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($subjects as $index => $subject)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration + ($subjects->currentPage() - 1) * $subjects->perPage() }}</th>
                                            <td>
                                                <div class="text-truncate" style="max-width: 250px;" title="{{ $subject->title }}">
                                                    {{ Str::limit($subject->title, 40) }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $subject->language?->name ?? '—' }}</span>
                                            </td>
                                            <td>
                                                <div class="text-muted small" title="{{ strip_tags($subject->description) }}">
                                                    {{ Str::limit(strip_tags($subject->description), 80) }}
                                                </div>
                                            </td>
                                            <td>{{ datejallali($subject->created_at, 1) }}</td>
                                            <td class="text-center">
                                                <div class="button-list">
                                                    <a href="{{ route('subject.edit', $subject->slug) }}"
                                                       class="btn btn-success-rgba btn-sm" title="ویرایش">
                                                        <i class="feather icon-edit-2"></i>
                                                    </a>
                                                    <form action="{{ route('subject.destroy', $subject->slug) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger-rgba btn-sm" title="حذف"
                                                                onclick="return confirm('آیا از حذف موضوع «{{ Str::limit($subject->title, 30) }}» مطمئن هستید؟')">
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

                            <div class="d-flex justify-content-center mt-4">
                                {{ $subjects->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
