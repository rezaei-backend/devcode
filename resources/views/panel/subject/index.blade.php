
@extends('panel.layouts.master')

@section('title', 'subject')

@section('content')

    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->

            <div class="col-lg-12">
                @if(session('unmassage'))
                    <div class="alert alert-danger" role="alert">
                        {{session('unmassage') }}
                    </div>
                @endif

                @if(session('massage'))
                    <div class="alert alert-success" role="alert">
                        {{session('massage') }}
                    </div>
                @endif
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{$error }}
                        </div>
                    @endforeach

                @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-dark">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">عنوان</th>
                                    <th scope="col">توضیحات</th>
                                    <th scope="col">زبان</th>
                                    <th scope="col">actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subjects as $subject )
                                <tr>
                                    <th scope="row">{{$subject->id}}</th>
                                    <td>{{$subject->title}}</td>
                                    <td>{{$subject->description}}</td>
                                    <td>{{$subject->name}}</td>
                                    <td><button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target=".bd-example-modal-{{$subject->id}}"><i class="dripicons-document-edit" ></i></button>
                                        <button type="button" class="btn btn-danger mt-1" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="dripicons-tag-delete" ></i></button>
                                    </td>
                                </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

            <a class="nav-link mb-2 active"  href="{{$subjects->nextPageUrl()}}" ><i class="dripicons-arrow-right"></i></a>
@for($i = 1; $i <= $subjects->lastPage(); $i++)
<a class="btn btn-primary" href="?page={{$i}}">{{$i}}</a>
@endfor
            <a class="nav-link mb-2 active"  href="{{$subjects->previousPageUrl()}}" role="tab" ><i class="dripicons-arrow-left"></i></a>
                </div>
            </div>
            <!-- End col -->







    @foreach($subjects as $subject)

                    <div class="modal fade bd-example-modal-{{$subject->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleLargeModalLabel">بروزرسانی</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <form action="/subjects/{{$subject->slug}}" method="post">
                                        @csrf
@method('put')

                                        <div class="contentbar">
                                            <!-- Start row -->
                                            <div class="row">

                                                <div class="col-lg-12">            @if($errors->any())
                                                        @foreach ($errors->all() as $error)
                                                            <div class="alert alert-danger" role="alert">
                                                                {{$error }}
                                                            </div>
                                                        @endforeach

                                                    @endif

                                                    <div class="card m-b-30">
                                                        <div class="card-header">
                                                            <h5 class="card-title">عنوان</h5>
                                                        </div>
                                                        <div class="card-body">

                                                            <div class="form-group mb-0">
                                                                <input type="text" class="form-control" name="title" id="inputText" value="{{$subject->title}}" placeholder="عنوان">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-6">
                                                    <div class="card m-b-30">
                                                        <div class="card-header">
                                                            <h5 class="card-title">متن </h5>
                                                        </div>
                                                        <div class="card-body">

                                                            <div class="form-group">
                                                                <textarea class="form-control" name="description" id="inputTextarea" rows="3"  placeholder="متن ">{{$subject->description}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="card m-b-30">
                                                        <div class="card-header">
                                                            <h5 class="card-title">زبان ها</h5>
                                                        </div>
                                                        <div class="card-body">

                                                            <div class="form-group">
                                                                <select class="form-control" name="language_id" id="formControlSelect">
                                                                    <option value="{{$subject->language_id}}" >{{$subject->name}}</option>
                                                                    @foreach($langs as $lang)
                                                                        <option value="{{$lang->id}}" >{{$lang->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <br>
                                                                <br>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>




                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>

                                    <button type="submit" class="btn btn-primary">ثبت</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleLargeModalLabel">حذف</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

<h4>ایا از حذف اطمینان دارید؟؟</h4>



                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                    <form action="/subjects/{{$subject->slug}}" method="post">
@csrf
                                        @method('delete')
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>


    @endforeach
@endsection
