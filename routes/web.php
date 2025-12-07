<?php

use App\Http\Controllers\Panel\AboutusController as PanelAboutusController;
use App\Http\Controllers\Panel\ActivityLogController as PanelActivityLogController;
use App\Http\Controllers\Panel\BlogController as PanelBlogController;
use App\Http\Controllers\Panel\CategoryController as PanelCategoryController;
use App\Http\Controllers\Panel\DocController as PanelDocController;
use App\Http\Controllers\Panel\LanguageController as PanelLanguageController;
use App\Http\Controllers\Panel\PanelController;
use App\Http\Controllers\Panel\questionController as PanelquestionController;
use App\Http\Controllers\Panel\QuizController as PanelQuizController;
use App\Http\Controllers\Panel\ResourceController as PanelResourceController;
use App\Http\Controllers\Panel\SettingController as PanelSettingController;
use App\Http\Controllers\Panel\SubjectController as PanelSubjectController;
use App\Http\Controllers\Panel\TagController as PanelTagController;
use App\Http\Controllers\Panel\TeamController as PanelTeamController;
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
    Route::resource('language', PanelLanguageController::class)->except(['show']);

    // آزمون‌ها
    Route::resource('quiz', PanelQuizController::class)->except(['show']);

    // === سوالات هر آزمون (مهم‌ترین قسمت) ===
    Route::prefix('quiz/{quiz}')->group(function () {
        Route::get('questions', [PanelquestionController::class, 'index'])
            ->name('question.index');

        Route::get('questions/create', [PanelquestionController::class, 'create'])
            ->name('question.create');

        Route::post('questions', [PanelquestionController::class, 'store'])
            ->name('question.store');

        Route::get('questions/{question}/edit', [PanelquestionController::class, 'edit'])
            ->name('question.edit');

        Route::put('questions/{question}', [PanelquestionController::class, 'update'])
            ->name('question.update');

        Route::delete('questions/{question}', [PanelquestionController::class, 'destroy'])
            ->name('question.destroy');
    });

    // موضوعات
    Route::resource('subjects', PanelSubjectController::class)
        ->names('subject')
        ->parameters(['subjects' => 'subject:slug'])
        ->except(['show']);

    // مستندات
    Route::resource('docs', PanelDocController::class)
        ->except(['show'])
        ->parameters(['docs' => 'doc'])
        ->names('doc');

    // تنظیمات
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [PanelSettingController::class, 'index'])->name('index');
        Route::get('/edit', [PanelSettingController::class, 'edit'])->name('edit');
        Route::put('/', [PanelSettingController::class, 'update'])->name('update');
    });

    Route::prefix('about-us')->name('aboutus.')->group(function () {
        Route::get('/', [PanelAboutusController::class, 'index'])->name('index');
        Route::get('/edit', [PanelAboutusController::class, 'edit'])->name('edit');
        Route::put('/update', [PanelAboutusController::class, 'update'])->name('update');
    });

    Route::post('/admin/resources', [PanelResourceController::class, 'storeOrUpdate'])
        ->name('resources.storeOrUpdate');

    Route::resource('blog', PanelBlogController::class)->except(['show']);

    Route::resource('category', PanelCategoryController::class)->except(['show']);

    Route::resource('tag', PanelTagController::class)->except(['show']);

    //    team
    Route::prefix('team')->group(function () {
        Route::get('/', [PanelTeamController::class, 'index'])->name('team.index');
        Route::get('create', [PanelTeamController::class, 'create'])->name('team.create');
        Route::post('/', [PanelTeamController::class, 'store'])->name('team.store');
        Route::get('{id}/edit', [PanelTeamController::class, 'edit'])->name('team.edit');
        Route::put('{id}', [PanelTeamController::class, 'update'])->name('team.update');
        Route::delete('{id}', [PanelTeamController::class, 'destroy'])->name('team.destroy');
    });

});

Route::delete('/activity-logs', [PanelActivityLogController::class, 'destroy'])
    ->name('activity-logs.destroy')
    ->middleware('admin');

require __DIR__.'/auth.php';

