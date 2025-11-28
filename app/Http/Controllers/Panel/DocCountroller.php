<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;


class DocCountroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (old('subject_id')){
            $oldsubject=Subject::find(old('subject_id'));
        }else{
            $oldsubject=null;
        }
$subjects = Subject::all();



return view('panel.doc.create',compact('subjects','oldsubject'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:docs',

            'subject_id' => 'required',
            'content' => 'required',
            'example_code'=>'required',
            'output'=>'required',


        ]);
        Doc::create($validatedData);

        return redirect()->route('doc.index')->with('massage','با موفقیت اپلود شد');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        echo "f";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doc=doc::find($id);

        $subjectinfo =Subject::find($doc->subject_id);

        $subjects=Subject::all();
//
        return view('panel.doc.edit',compact('doc','subjects','subjectinfo'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $doc = doc::find($id);
        if ($doc->title != $request->title){
            $validatedData = $request->validate([
                'title' => 'required|unique:docs',
                'subject_id' => 'required',
                'content' => 'required',
                'example_code' => 'required',
                'output' => 'required',
            ]);
    }else
{
    $validatedData = $request->validate([
        'title' => 'required',
        'subject_id' => 'required',
        'content' => 'required',
        'example_code' => 'required',
        'output' => 'required',
    ]);
}
        $doc->slug=null;
        $doc->update($validatedData);
        $doc->save();

        return redirect()->route('doc.index')->with('massage','با موفقیت اپدیت شد');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

    }
}
