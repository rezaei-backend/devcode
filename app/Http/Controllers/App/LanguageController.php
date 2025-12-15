<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Subject;

class LanguageController extends Controller
{
    public function singleLanguage(Language $language)
    {
        $setting=Setting::first();
        $subjects=Subject::where('language_id',$language->id)->get();
        $languages=Language::all();
        return view('app.language.index',compact('language','setting','subjects','languages'));
    }
}
