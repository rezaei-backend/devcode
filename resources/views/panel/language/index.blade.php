@extends('panel.layouts.master')
@section('title','زبان برنامه نویسی')

@section('content')
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">زبان برنامه نویسی</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table foo-basic-table">
                                <thead>
                                <tr>
                                    <th data-breakpoints="xs">#</th>
                                    <th>زبان برنامه نویسی</th>
                                    <th>اسلاگ</th>
                                    <th>رنگ1</th>
                                    <th>رنگ2</th>
                                   <th>فعالیت</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($laguages as $language)
                                <tr data-expanded="true">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$language->name}}</td>
                                    <td>{{$language->slug}}</td>
                                    <td>
                                        <span class="badge bg-{{$language->primary_color}}"></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{$language->secondary_color}}"></span>
                                    </td>
                                    <td>
                                        <div  role="group">
                                            <a href="{{ route('language.edit', $language->slug) }}"
                                               class="btn btn-round btn-warning"
                                               title="ویرایش">
                                                <i class="feather icon-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-round btn-danger mt-1 model-animation-btn" data-animation="zoomIn" data-toggle="modal" data-target="#deleteModalCenter{{ $language->id }}" title="حذف">
                                                <i class="feather icon-trash-2"></i>
                                            </button>
{{--                                            <button type="button" class="btn btn-round btn-danger"><i class="feather icon-trash-2"></i></button>--}}
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="deleteModalCenter{{ $language->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalCenter{{ $language->id }}Title-1">Modal Title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('language.destroy',$language->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Ok</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @empty
                                    <span>جدول زبان خالی است</span>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End row -->

    </div>
@endsection
