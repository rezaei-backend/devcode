
@extends('panel.layouts.master')

@section('title','اپدیت')

@section('content')
    <form action="/admin/docs/{{$doc->id}}" method="post" >
        @csrf
@method('PUT')
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
                                <input type="text" class="form-control" name="title" id="inputText" value="{{$doc->title}}" placeholder="عنوان">
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
                                    <option value="{{$subjectinfo->id}}" >{{$subjectinfo->langitem->name.'/'.$subjectinfo->title}}</option>

                                        <option value="" >یکی را انتخاب کنید</option>

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
                                <textarea class="form-control" style="background-color: #2b2a2a ; color: white" name="example_code" id="inputTextarea" rows="5"  placeholder="کد">{{$doc->example_code}}</textarea>
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
                                <textarea class="form-control" name="output" id="inputTextarea" rows="5"  placeholder="خروجی">{{$doc->output}}</textarea>
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
                                <textarea class="form-control" name="content" id="inputTextarea" rows="3"  placeholder="متن">{{$doc->content}}</textarea>

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
