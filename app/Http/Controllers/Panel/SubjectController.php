<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Resource;
use App\Models\Subject;
use Illuminate\Http\Request;


class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $langs = Language::all();
        $subjects=Subject::orderBy('created_at', 'desc')->paginate(5);

        return view('panel.subject.index',compact('subjects','langs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!empty(old('language_id'))) {
            $oldlang=Language::find(old('language_id'));
        }else{
            $oldlang=null;
        }
        $langs = Language::all();
        return view('panel.subject.create',compact('langs', "oldlang"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:subjects',
            'description' => 'required',


            'language_id' => 'required',
        ]);

        subject::create($validatedData);

return redirect('admin/subjects/')->with('massage','با موفقیت ثبت شد');
    }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
//        if is dir
        $subject=Subject::whereSlug($slug)->get()->first();
        if($subject->title != $request->title){
        $validatedData = $request->validate([
            'title' => 'required|unique:subjects',

            'description' => 'required',



            'language_id' => 'required',
        ]);
        }else{
            $validatedData = $request->validate([
                'title' => 'required',

                'description' => 'required',



                'language_id' => 'required',
            ]);
        }
        $subject->slug=null;
        $subject->fill($validatedData);


        $subject->save();
        return back()->with('massage','با موفقیت اپدیت شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
$subject=Subject::whereSlug($slug);
$subject->delete();
return back()->with('unmassage','با موفقیت حذف شد');
    }
}
