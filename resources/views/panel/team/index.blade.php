@extends('panel.layouts.master')

@section('title', 'تیم ما')

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="card-title mb-0">تیم ما ({{ $teams->total() }})</h5>
                            </div>
                            <div class="col-6 text-left">
                                <a href="{{ route('team.create') }}" class="btn btn-primary-rgba">
                                    ایجاد فرد جدید
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(session('unmassage'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('unmassage') }}
                            </div>
                        @endif

                        @if(session('massage'))
                            <div class="alert alert-success" role="alert">
                                {{ session('massage') }}
                            </div>
                        @endif

                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        @if($teams->isEmpty())
                            <div class="text-center py-5">
                                <p class="text-muted">هنوز هیچ فردی ایجاد نشده است.</p>
                                <a href="{{ route('team.create') }}" class="btn btn-primary-rgba">ایجاد اولین فرد</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover table-borderless align-middle">
                                    <thead>
                                    <tr class="text-muted">
                                        <th>#</th>
                                        <th>اسم کامل</th>
                                        <th>تخصص</th>
                                        <th>ایمیل</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($teams as $team)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $team->fullname }}</strong>
                                            </td>
                                            <td>
                                                {{ $team->Expertise }}
                                            </td>
                                            <td>
                                                {{ $team->email }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('team.edit', $team->id) }}" class="btn btn-success-rgba btn-sm" title="ویرایش">
                                                    <i class="feather icon-edit-2"></i>
                                                </a>
                                                <form action="{{ route('team.destroy', $team->id) }}" method="POST" style="display:inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-rgba btn-sm" title="حذف"
                                                            onclick="return confirm('آیا از حذف فرد «{{ $team->fullname }}» مطمئن هستید؟')">
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
                                {{ $teams->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
