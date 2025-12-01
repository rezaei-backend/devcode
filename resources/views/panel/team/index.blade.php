



@extends('panel.layouts.master')

@section('title', 'تیم ما')

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

                @if(!empty($teams->toArray()))
                    <div class="table-responsive">
                        <table class="table table-bordered table-white">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">اسم کامل</th>
                                <th scope="col">تخصص</th>
                                <th scope="col">ایمیل</th>
                                <th scope="col">actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($teams as $team )

                                <tr>

                                    <th scope="row">{{$team->id}}</th>

                                    <td>{{$team->fullname}}</td>
                                    <td>{{$team->Expertise}}</td>
                                    <td>{{$team->email}}</td>
                                    <td><button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target=".bd-example-modal-{{$team->id}}"><i class="dripicons-document-edit" ></i></button>
                                        <button type="button" class="btn btn-danger mt-1" data-toggle="modal" data-target=".bd-example-modal-delete{{$team->id}}"><i class="dripicons-tag-delete" ></i></button>




                                    </td>
                                </tr>

                            @endforeach


                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="container" >
                        <h1>تیم  ما خالی است</h1>
                    </div>
                @endif
            </div>



        </div>
    </div>
    <!-- End col -->







    @foreach($teams as $team)




        <div class="modal fade bd-example-modal-{{$team->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleLargeModalLabel">بروزرسانی</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form action="/admin/team/{{$team->id}}/update" method="post" enctype="multipart/form-data">
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
                                    </div>






                                    <div class="col-lg-6">
                                        <div class="card m-b-30">
                                            <div class="card-header">
                                                <h5 class="card-title">نام کامل</h5>
                                            </div>
                                            <div class="card-body">

                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" name="fullname" id="inputText" value="{{$team->fullname}}" placeholder="نام فرد مورد نظر را وارد کنید">
                                                </div>
                                            </div>
                                        </div>
                                    </div>









                                    <div class="col-lg-6">
                                        <div class="card m-b-30">
                                            <div class="card-header">
                                                <h5 class="card-title">تخصص</h5>
                                            </div>
                                            <div class="card-body">

                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" name="Expertise" id="inputText" value="{{$team->Expertise}}" placeholder="تخصص فرد مورد نظر را وارد کنید">
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-lg-12">
                                        <div class="card m-b-30">
                                            <div class="card-header">
                                                <h5 class="card-title">email</h5>
                                            </div>
                                            <div class="card-body">

                                                <div class="form-group mb-0">
                                                    <input type="text" class="form-control" name="email" id="inputText" value="{{$team->email}}" placeholder="ایمیل فرد مورد نظر را وارد کنید">
                                                </div>
                                            </div>
                                        </div>
                                    </div>











                                    <div class="col-12">
                                        <!-- Start col -->
                                        <div class="card m-b-30">
                                            <div class="card-header">
                                                <h5 class="card-title">File upload</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="fallback">
                                                    <input name="image" type="file" >
                                                </div>
                                                <div class="text-center m-t-15">

                                                </div>
                                            </div>
                                        </div>
                                    </div>








                                </div>
                            </div>




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>

                        <button type="submit" class="btn btn-primary">بروزرسانی</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-delete{{$team->id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleLargeModalLabel">حذف</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <h4>ایا از حذف اطمینان دارید؟؟"<span style="color: red">{{$team->fullname}}</span>"</h4>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                        <form action="/admin/team/{{$team->id}}" method="post">
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

