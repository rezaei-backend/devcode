<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('panel.index');
});
Route::get('/form', function () {
    return view('panel.form');
});
