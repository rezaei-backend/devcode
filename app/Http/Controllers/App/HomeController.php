<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $setting=Setting::first();
        $languages=Language::all();
        return view('app.index',compact('languages','setting'));
    }
}
