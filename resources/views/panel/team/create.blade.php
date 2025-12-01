

@extends('panel.layouts.master')

@section('title', 'تیم ما')

@section('content')


    <form action="{{route('team.store')}}" method="post" enctype="multipart/form-data">
        @csrf


        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <div class="col-lg-12">
                            @if($errors->any())
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
                                <input type="text" class="form-control" name="fullname" id="inputText" value="{{old('fullname')}}" placeholder="نام فرد مورد نظر را وارد کنید">
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
                                <input type="text" class="form-control" name="Expertise" id="inputText" value="{{old('Expertise')}}" placeholder="تخصص فرد مورد نظر را وارد کنید">
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
                            <input type="text" class="form-control" name="email" id="inputText" value="{{old('email')}}" placeholder="ایمیل فرد مورد نظر را وارد کنید">
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
                                <button type="submit" class="btn btn-primary">ثبت</button>
                            </div>
                        </div>
                    </div>
                </div>









        </div>
        </div>

    </form>

@endsection
