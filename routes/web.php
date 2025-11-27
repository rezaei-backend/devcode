<?php

use App\Http\Controllers\Panel\AboutusController;
use App\Http\Controllers\Panel\questionController;
use App\Http\Controllers\Panel\QuizController;
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
    Route::resource('quiz', QuizController::class);


    // همه روت‌های مربوط به سوالات یک آزمون
    Route::prefix('quiz/{quiz_id}')->group(function () {

        Route::get('questions', [questionController::class, 'index'])
            ->name('question.index');

        // ایجاد سوال جدید
        Route::get('questions/create', [questionController::class, 'create'])
            ->name('question.create');
        Route::post('questions', [questionController::class, 'store'])
            ->name('question.store');

        // ویرایش سوال
        Route::get('questions/{question_id}/edit', [questionController::class, 'edit'])
            ->name('question.edit');
        Route::put('questions/{question_id}', [questionController::class, 'update'])
            ->name('question.update');

        // حذف سوال
        Route::delete('questions/{question_id}', [questionController::class, 'destroy'])
            ->name('question.destroy');
    });

    Route::patch('quiz/questions/{question_id}/toggle', [questionController::class, 'toggle'])
        ->name('question.toggle');


//    Route::resource('question', questionController::class);
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subject.index');
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subject.create');
    Route::post('/subjects/create', [SubjectController::class, 'store'])->name('subject.store');
    Route::put('/subjects/{slug}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subjects/{slug}', [SubjectController::class, 'destroy'])->name('subject.destroy');

    Route::resource('docs', DocCountroller::class)->names('doc');

    Route::get('about', [AboutusController::class, 'edit'])->name('about.edit');
    Route::put('about', [AboutusController::class, 'update'])->name('about.update');

    });
