@extends('panel.layouts.master')
@section('title', 'مدیریت مستندات')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">مستندات</h5>
                        <a href="{{ route('doc.create') }}" class="btn btn-primary-rgba">
                            ایجاد مستند جدید
                        </a>
                    </div>

                    <div class="card-body">
                        @if(session('massage'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('massage') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($docs->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted fs-5">هنوز هیچ مستندی ایجاد نشده است.</p>
                                <a href="{{ route('doc.create') }}" class="btn btn-primary-rgba">ایجاد اولین مستند</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle">
                                    <thead>
                                    <tr style="border-bottom: 2px solid #ebebeb;">
                                        <th>#</th>
                                        <th>تصویر</th>
                                        <th>عنوان مستند</th>
                                        <th>موضوع</th>
                                        <th>زبان</th>
                                        <th>تاریخ ایجاد</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($docs as $doc)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($doc->image)
                                                    <img src="{{ asset('uploads/docs/' . $doc->image) }}"
                                                         class="rounded shadow-sm" style="width:60px;height:60px;object-fit:cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm"
                                                         style="width:60px;height:60px;">
                                                        <i class="feather icon-file-text text-muted fs-4"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('doc.edit', $doc->id) }}" class="text-primary fw-bold">
                                                    {{ Str::limit($doc->title, 50) }}
                                                </a>
                                            </td>
                                            <td>{{ $doc->subject->title ?? '—' }}</td>
                                            <td>
                                                    <span class="badge text-white px-3 py-2" style="background-color: {{ $doc->subject->langitem->primary_color ?? '#666' }}">
                                                        {{ $doc->subject->langitem->name ?? 'نامشخص' }}
                                                    </span>
                                            </td>
                                            <td>{{ datejallali($doc->created_at, 1) }}</td>
                                            <td class="text-center">
                                                <div class="button-list">
                                                    <a href="{{ route('doc.edit', $doc->id) }}"
                                                       class="btn btn-success-rgba btn-sm" title="ویرایش">
                                                        <i class="feather icon-edit-2"></i>
                                                    </a>
                                                    <form action="{{ route('doc.destroy', $doc->id) }}" method="POST" style="display:inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger-rgba btn-sm" title="حذف"
                                                                onclick="return confirm('آیا از حذف «{{ $doc->title }}» مطمئن هستید؟')">
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
                                {{ $docs->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
