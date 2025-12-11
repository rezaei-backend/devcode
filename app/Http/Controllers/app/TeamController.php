<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('app.team.index',compact('teams'));
    }
}
