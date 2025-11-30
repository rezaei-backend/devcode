@extends('Panel.Layouts.master')
@section('title', 'مدیریت دسته‌بندی‌های مقالات')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">دسته‌بندی‌های مقالات ({{ $categories->total() }})</h5>
                            </div>
                            <div class="col-6 text-left">
                                <a href="{{ route('category.create') }}" class="btn btn-primary-rgba">
                                    ایجاد دسته بندی
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if($categories->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">هنوز دسته‌بندی‌ای ایجاد نشده است.</p>
                                <a href="{{ route('category.create') }}" class="btn btn-primary-rgba">ایجاد اولین دسته‌بندی</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless align-middle">
                                    <thead>
                                    <tr class="text-muted">
                                        <th>#</th>
                                        <th>نام دسته‌بندی</th>
                                        <th>اسلاگ</th>
                                        <th>تعداد مقالات</th>
                                        <th>تاریخ ایجاد</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $category->name }}</strong>
                                            </td>
                                            <td>
                                                <code class="text-muted">{{ $category->slug }}</code>
                                            </td>
                                            <td>
                                            <span class="badge badge-info">
                                                {{ $category->blogs->count() }}
                                            </span>
                                            </td>
                                            <td>
                                                @if($category->updated_at)
                                                    {{ datejallali($category->updated_at, true) }}
                                                @else
                                                    نامشخص
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-success-rgba btn-sm" title="ویرایش">
                                                    <i class="feather icon-edit-2"></i>
                                                </a>
                                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-rgba btn-sm" title="حذف"
                                                            onclick="return confirm('آیا از حذف دسته «{{ $category->name }}» مطمئن هستید؟')">
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
                                {{ $categories->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
