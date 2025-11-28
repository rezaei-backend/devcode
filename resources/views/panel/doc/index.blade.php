@extends('panel.layouts.master')
@section('title', 'مدیریت مستندات')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">مستندات</h5>
                        <a href="{{ route('doc.create') }}" class="btn btn-primary-rgba">ایجاد مستند جدید</a>
                    </div>
                    <div class="card-body">
                        @if($docs->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted fs-5">هنوز هیچ مستندی ایجاد نشده است.</p>
                                <a href="{{ route('doc.create') }}" class="btn btn-primary-rgba">ایجاد اولین مستند</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle">
                                    <thead>
                                    <tr>
                                        <th>#</th>
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
                                                <a href="{{ route('doc.edit', $doc->id) }}" class="text-primary fw-bold">
                                                    {{ Str::limit($doc->title, 50) }}
                                                </a>
                                            </td>
                                            <td>{{ $doc->subject->title ?? '—' }}</td>
                                            <td>{{ $doc->subject->langitem->name ?? 'نامشخص' }}</td>
                                            <td>{{ datejallali($doc->created_at, 1) }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('doc.edit', $doc->id) }}" class="btn btn-success-rgba btn-sm">ویرایش</a>
                                                <form action="{{ route('doc.destroy', $doc->id) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-rgba btn-sm" onclick="return confirm('آیا مطمئن هستید؟')">حذف</button>
                                                </form>
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
