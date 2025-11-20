<?php

use App\Http\Controllers\Panel\LanguageController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('panel.index');
});
Route::get('/edit', function () {
    return view('panel.language.edit');
});

Route::prefix('admin')->group(function () {
    Route::resource('language', LanguageController::class);

});

