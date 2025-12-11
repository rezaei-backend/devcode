@extends('Panel.Layouts.master')
@section('title', 'مدیریت مقالات')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">مقالات بلاگ ({{ $blogs->total() }})</h5>
                            </div>
                            <div class="col-6 text-left">
                                <a href="{{ route('category.create') }}" class="btn btn-primary-rgba">
                                    ایجاد دسته بندی مقاله
                                </a>
                                <a href="{{ route('blog.create') }}" class="btn btn-primary-rgba">
                                    ایجاد مقاله جدید
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($blogs->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">هنوز مقاله‌ای ایجاد نشده</p>
                                <a href="{{ route('blog.create') }}" class="btn btn-primary-rgba">ایجاد اولین مقاله</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>تصویر</th>
                                        <th>عنوان</th>
                                        <th>دسته</th>
                                        <th>تگ‌ها</th>
                                        <th>بازدید</th>
                                        <th>تاریخ</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($blogs as $blog)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($blog->image)
                                                    <img src="{{ asset('images/blog/' . $blog->image) }}" class="rounded" style="width:60px;height:60px;object-fit:cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:60px;height:60px;">
                                                        <i class="feather icon-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ Str::limit($blog->title, 40) }}</td>
                                            <td><span class="badge badge-info">{{ $blog->category->name }}</span></td>
                                            <td>
                                                @foreach($blog->tags->take(3) as $tag)
                                                    <span class="badge badge-secondary badge-sm">{{ $tag->name }}</span>
                                                @endforeach
                                                @if($blog->tags->count() > 3) <small class="text-muted">+{{ $blog->tags->count() - 3 }}</small> @endif
                                            </td>
                                            <td>{{ number_format($blog->views) }}</td>
                                            <td>
                                                @if($blog->updated_at)
                                                    {{ datejallali($blog->updated_at, true) }}
                                                @else
                                                    نامشخص
                                                @endif</td>
                                            <td>
                                                <a href="{{ route('blog.edit', $blog->id) }}" class="btn btn-success-rgba btn-sm">ویرایش</a>
                                                <form action="{{ route('blog.destroy', $blog->id) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-rgba btn-sm" onclick="return confirm('حذف مقاله؟')">حذف</button>
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
