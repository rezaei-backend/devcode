<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResoureceContoroller extends Controller
{
    public function store(Request $request)
    {
$vaildate=$request->validate([
   'title'=>'required|max:255',
   'url'=>'required',
    'subject_id'=>'required',

]);
Resource::create($vaildate);

return redirect()->back()->with('massage','با موفقیت ثبت شد');
    }



    public function update($id, Request $request){

        $vaildate=$request->validate([
            'title'=>'required|max:255',
            'url'=>'required',
            'subject_id'=>'required',

        ]);
        $resource=Resource::find($id);
        $resource->fill($vaildate);
        $resource->save();

        return redirect()->back()->with('massage' , 'با موفقیت اپدیت شد');
    }
}
