<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\panel\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return view('panel.languages.index', compact('languages'));
    }
    public function create()
    {
        return view('panel.languages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:100|unique:languages,slug',
            'primary_color' => 'required|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
        ]);

        Language::create($request->only(['name', 'slug', 'primary_color', 'secondary_color']));

        return redirect()->route('languages.index')->with('success', 'زبان با موفقیت اضافه شد.');
    }
}
