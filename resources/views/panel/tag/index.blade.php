@extends('Panel.Layouts.master')
@section('title', 'مدیریت تگ‌های مقالات')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">تگ‌های مقالات ({{ $tags->total() }})</h5>
                            </div>
                            <div class="col-6 text-left">
                                <a href="{{ route('tag.create') }}" class="btn btn-primary-rgba">
                                    ایجاد  تگ جدید
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($tags->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">هنوز تگی ایجاد نشده است.</p>
                                <a href="{{ route('tag.create') }}" class="btn btn-primary-rgba">ایجاد اولین تگ</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless align-middle">
                                    <thead>
                                    <tr class="text-muted">
                                        <th>#</th>
                                        <th>نام تگ</th>
                                        <th>اسلاگ</th>
                                        <th>تعداد استفاده</th>
                                        <th>تاریخ ایجاد</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tags as $tag)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <span class="badge badge-secondary px-3 py-2">{{ $tag->name }}</span>
                                            </td>
                                            <td>
                                                <code class="text-muted">{{ $tag->slug }}</code>
                                            </td>
                                            <td>
                                            <span class="badge badge-success">
                                                {{ $tag->blogs->count() }}
                                            </span>
                                            </td>
                                            <td>
                                                @if($tag->updated_at)
                                                    {{ datejallali($tag->updated_at, true) }}
                                                @else
                                                    نامشخص
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('tag.edit', $tag->id) }}" class="btn btn-success-rgba btn-sm" title="ویرایش">
                                                    <i class="feather icon-edit-2"></i>
                                                </a>
                                                <form action="{{ route('tag.destroy', $tag->id) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-rgba btn-sm" title="حذف"
                                                            onclick="return confirm('آیا از حذف تگ «{{ $tag->name }}» مطمئن هستید؟')">
                                                        <i class="feather icon-trash-2"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- صفحه‌بندی -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $tags->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
