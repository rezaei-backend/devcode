
@extends('panel.layouts.master')

@section('title','مقاله')

@section('content')
    <form action="{{route('doc.store')}}" method="post" >
        @csrf

    <div class="contentbar">
        <!-- Start row -->
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{$error }}
                </div>
            @endforeach

        @endif
        <div class="row">


<div class="col-6" >
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
                            <h5 class="card-title">سابجکت ها</h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <select class="form-control" name="subject_id" id="formControlSelect">
                                    @if(!empty(old('subject_id')))
                                    <option value="{{old('subject_id')}}" >{{$oldsubject->title}}</option>
                                    @else
                                        <option value="">یکی را انتخاب کنید</option>
                                    @endif
                          @foreach($subjects as $subject)

                                        <option value="{{$subject->id}}" >{{$subject->langitem->name.'/'.$subject->title}}</option>
                          @endforeach
                                </select>


                            </div>
                        </div>
                    </div>




        </div>
                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">کد </h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <textarea class="form-control" style="  background-color: #2b2a2a ; color: white" name="example_code" id="inputTextarea" rows="3" placeholder="کد ">{{old('example_code')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">خروجی </h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <textarea class="form-control" name="output" id="inputTextarea" rows="3"  placeholder="خروجی">{{old('output')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">متن </h5>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <textarea class="form-control" name="content" id="inputTextarea" rows="3"  placeholder="متن">{{old('content')}}</textarea>

                            </div>
                            <button type="submit" class="btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
        </div>


    </div>
    </div>

    </form>
@endsection
