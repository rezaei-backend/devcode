@extends('panel.layouts.master')
@section('title','subject')
@section('content')


    <form action="{{route('subject.store')}}" method="post">
        @csrf


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
                        <input type="text" class="form-control" name="title" id="inputText" value="{{old('title')}}" placeholder="عنوان">
                    </div>
                </div>
            </div>
        </div>


                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">توضیحات </h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <textarea class="form-control" name="description" id="inputTextarea" rows="3"  placeholder="متن ">{{old('description')}}</textarea>
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
                                    @if(!empty(old('language_id')))
                                        <option value="{{old('language_id')}}" >{{$oldlang->name}}</option>
                                    @else
                                        <option value="">یکی را انتخاب کنید</option>
                                    @endif

                                    @foreach($langs as $lang)
                                    <option value="{{$lang->id}}" >{{$lang->name}}</option>
                                    @endforeach
                                </select>
                                <br>
                                <br>
                                <button type="submit" class="btn btn-primary">ثبت</button>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>

    </form>
@endsection
