<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        return view('panel.index');
    }
}
