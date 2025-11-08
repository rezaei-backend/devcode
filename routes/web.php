<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\LanguageController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('panel.index');
});
Route::get('/form', function () {
    return view('panel.form');
});

Route::prefix('panel')->group(function () {
    Route::resource('languages', LanguageController::class);
});

