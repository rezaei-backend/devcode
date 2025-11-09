<?php

use App\Http\Controllers\Panel\LanguageController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('panel.index');
});
Route::get('/edit', function () {
    return view('panel.language.edit');
});


Route::resource('language', LanguageController::class);
