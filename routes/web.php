<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Panel\LanguageController;
use App\Http\Controllers\Panel\SubjectController;
use App\Http\Controllers\Panel\DocCountroller;



// داشبورد Breeze
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// پروفایل Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::prefix('admin')->group(function () {
    Route::resource('language', LanguageController::class);

    Route::get('/subjects', [SubjectController::class, 'index'])->name('subject.index');
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subject.create');
    Route::post('/subjects/create', [SubjectController::class, 'store'])->name('subject.store');
    Route::put('/subjects/{slug}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subjects/{slug}', [SubjectController::class, 'destroy'])->name('subject.destroy');

    Route::resource('docs', DocCountroller::class)->names('doc');
});

// auth routes
//require __DIR__.'/auth.php';
