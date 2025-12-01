<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
Route::prefix('admin')->group(function () {
Route::get('/subjects', [\App\Http\Controllers\Panel\SubjectController::class, 'index'])->name('subject.index');
Route::get('/subjects/create', [\App\Http\Controllers\Panel\SubjectController::class, 'create'])->name('subject.create');
Route::post('/subjects/create', [\App\Http\Controllers\Panel\SubjectController::class, 'store'])->name('subject.store');
Route::put('/subjects/{slug}', [\App\Http\Controllers\Panel\SubjectController::class, 'update'])->name('subject.update');
Route::delete('/subjects/{slug}', [\App\Http\Controllers\Panel\SubjectController::class, 'destroy'])->name('subject.destroy');



Route::resource('docs', \App\Http\Controllers\Panel\DocCountroller::class)->names('doc');


// resourece

    Route::post('/resource/store', [\App\Http\Controllers\panel\ResoureceContoroller::class, 'store']);
    Route::put('/resource/{id}',[\App\Http\Controllers\panel\ResoureceContoroller::class, 'update']);

//    end resourece

//    team
    Route::get('team/create', [\App\Http\Controllers\Panel\TeamController::class, 'create'])->name('team.create');
    Route::post('team/create', [\App\Http\Controllers\Panel\TeamController::class, 'store'])->name('team.store');
    Route::put('team/{id}/update', [\App\Http\Controllers\Panel\TeamController::class, 'update'])->name('team.update');
    Route::delete('team/{id}', [\App\Http\Controllers\Panel\TeamController::class, 'destroy'])->name('team.destroy');
    Route::get('team/',[\App\Http\Controllers\Panel\TeamController::class, 'index'])->name('team.index');

//    endteam
});




require __DIR__.'/auth.php';
