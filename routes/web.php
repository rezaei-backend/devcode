<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\LanguageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('panel')->group(function () {
    Route::resource('languages', LanguageController::class);
});


Route::prefix('admin')->group(function () {

    Route::get('/subjects', [\App\Http\Controllers\Panel\SubjectController::class, 'index'])->name('subject.index');
    Route::get('/subjects/create', [\App\Http\Controllers\Panel\SubjectController::class, 'create'])->name('subject.create');
    Route::post('/subjects/create', [\App\Http\Controllers\Panel\SubjectController::class, 'store'])->name('subject.store');
    Route::put('/subjects/{slug}', [\App\Http\Controllers\Panel\SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subjects/{slug}', [\App\Http\Controllers\Panel\SubjectController::class, 'destroy'])->name('subject.destroy');

    Route::resource('docs', \App\Http\Controllers\Panel\DocCountroller::class)->names('doc');

});

require __DIR__.'/auth.php';
