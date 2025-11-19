<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LanguageController extends Controller
{

    public function index()
    {
        $languages=Language::all();
        return view('panel.language.index',compact('languages'));
    }


    public function create()
    {
        return view('panel.language.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'logo'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',

        ]);

        $data=$request->all();
        $destinationPath=public_path('Panel/pictures/language');

        if ($request->hasFile('logo')){
            $fileName=time() . '_' .$request->file('logo')->getClientOriginalName();
            $request->file('logo')->move($destinationPath,$fileName);
            $data['logo']=$fileName;
        }

        Language::create($data);

        return redirect()->route('language.index')->with('success','');
    }


    public function show(string $id)
    {
        //
    }


    public function edit($slug)
    {
        $language=Language::where('slug',$slug)->firstorFail();
        return view('panel.language.edit',compact('language'));
    }


    public function update(Request $request, string $id)
    {
        $language = Language::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
        ]);
        $data=$request->all();

        $language->update($data);

        return redirect()->route('language.index')->with('success','زبان ویرایش شد');

    }


    public function destroy(string $id)
    {
        $language=Language::findorFail($id);

        $destinationPath=public_path('Panel/pictures/language');

        if ($language->logo && File::exists($destinationPath . $language->logo)) {
            File::delete($destinationPath . $language->logo);
        }


        $language->delete();
        return redirect()->route('language.index')->with('success','زبان حذف شد');
    }
}
