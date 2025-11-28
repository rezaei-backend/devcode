<?php

use App\Http\Controllers\Panel\AboutusController;
use App\Http\Controllers\Panel\ActivityLogController;
use App\Http\Controllers\Panel\DocController;
use App\Http\Controllers\Panel\LanguageController;
use App\Http\Controllers\Panel\PanelController;
use App\Http\Controllers\Panel\questionController;
use App\Http\Controllers\Panel\QuizController;
use App\Http\Controllers\Panel\ResourceController;
use App\Http\Controllers\Panel\SettingController;
use App\Http\Controllers\Panel\SubjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// صفحه اصلی
Route::get('/', function () {
    return view('welcome');
});

// پروفایل کاربر
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('Admin')->middleware('admin')->group(function () {

    Route::get('/', [PanelController::class, 'index'])->name('Admin');

    // زبان‌ها
    Route::resource('language', LanguageController::class)->except(['show']);

    // آزمون‌ها
    Route::resource('quiz', QuizController::class)->except(['show']);

    // === سوالات هر آزمون (مهم‌ترین قسمت) ===
    Route::prefix('quiz/{quiz}')->group(function () {
        Route::get('questions', [questionController::class, 'index'])
            ->name('question.index');

        Route::get('questions/create', [questionController::class, 'create'])
            ->name('question.create');

        Route::post('questions', [questionController::class, 'store'])
            ->name('question.store');

        Route::get('questions/{question}/edit', [questionController::class, 'edit'])
            ->name('question.edit');

        Route::put('questions/{question}', [questionController::class, 'update'])
            ->name('question.update');

        Route::delete('questions/{question}', [questionController::class, 'destroy'])
            ->name('question.destroy');
    });

    // موضوعات
    Route::resource('subjects', SubjectController::class)
        ->names('subject')
        ->parameters(['subjects' => 'subject:slug'])
        ->except(['show']);

    // مستندات
    Route::resource('docs', DocController::class)
        ->except(['show'])
        ->parameters(['docs' => 'doc'])
        ->names('doc');

    // تنظیمات
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::get('/edit', [SettingController::class, 'edit'])->name('edit');
        Route::put('/', [SettingController::class, 'update'])->name('update');
    });

    Route::prefix('about-us')->name('aboutus.')->group(function () {
        Route::get('/', [AboutusController::class, 'index'])->name('index');
        Route::get('/edit', [AboutusController::class, 'edit'])->name('edit');
        Route::put('/update', [AboutusController::class, 'update'])->name('update');
    });

    Route::prefix('resources')->name('resources.')->group(function () {
        Route::post('/store', [ResourceController::class, 'store'])->name('store');
        Route::put('/{resource}', [ResourceController::class, 'update'])->name('update');
        Route::delete('/{resource}', [ResourceController::class, 'destroy'])->name('destroy');
    });

});

Route::delete('/activity-logs', [ActivityLogController::class, 'destroy'])
    ->name('activity-logs.destroy')
    ->middleware('admin');

require __DIR__.'/auth.php';

