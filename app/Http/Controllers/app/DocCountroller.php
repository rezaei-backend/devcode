<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use App\Models\Language;
use App\Models\Subject;
use App\Traits\DocActive;
use Illuminate\Http\Request;

class DocCountroller extends Controller
{
    use DocActive;
    public function show($lang,$slug=null)
    {
        $languge=Language::where('slug',$lang)->firstOrFail();
        $menus=Subject::with('docjoin')->where('language_id',$languge->id)->get();
        if ($slug!=null) {
            $doc = Doc::with('subject')->where('slug', $slug)->firstOrFail();
        }else{
            $doc = Doc::with('subject')->join('subjects','subjects.id','=','docs.subject_id')->join('Languages','Languages.id','=','subjects.language_id')->where('docs.title', 'home')->orWhere('docs.title','introduce')->orWhere('docs.title','basic')->firstOrFail();

        }
        $nextdoc=Doc::where('id',$doc->id+1)->first();

            $subjects = $doc->subject;


            $textcher= $this->textdoc($doc);
        $langs=Language::all();
        return view('app.doc.index',compact('doc','textcher','langs','subjects',
        'nextdoc','menus','languge'));
    }

}
