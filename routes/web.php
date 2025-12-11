<?php

use App\Http\Controllers\Panel\AboutusController;
use App\Http\Controllers\Panel\ActivityLogController;
use App\Http\Controllers\Panel\BlogController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\ContactusController;
use App\Http\Controllers\Panel\DocController;
use App\Http\Controllers\Panel\LanguageController;
use App\Http\Controllers\Panel\PanelController;
use App\Http\Controllers\Panel\questionController;
use App\Http\Controllers\Panel\QuizController;
use App\Http\Controllers\Panel\ResourceController;
use App\Http\Controllers\Panel\SettingController;
use App\Http\Controllers\App\HomeController;
use App\Http\Controllers\Panel\AboutusController as PanelAboutusController;
use App\Http\Controllers\Panel\ActivityLogController as PanelActivityLogController;
use App\Http\Controllers\Panel\BlogController as PanelBlogController;
use App\Http\Controllers\Panel\CategoryController as PanelCategoryController;
use App\Http\Controllers\Panel\DocController as PanelDocController;
use App\Http\Controllers\Panel\LanguageController as PanelLanguageController;
use App\Http\Controllers\Panel\questionController as PanelquestionController;
use App\Http\Controllers\Panel\QuizController as PanelQuizController;
use App\Http\Controllers\Panel\ResourceController as PanelResourceController;
use App\Http\Controllers\Panel\SettingController as PanelSettingController;
use App\Http\Controllers\Panel\SubjectController as PanelSubjectController;
use App\Http\Controllers\Panel\TagController as PanelTagController;
use App\Http\Controllers\Panel\TeamController as PanelTeamController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Panel\SubjectController;
use App\Http\Controllers\Panel\TagController;

// صفحه اصلی
Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [HomeController::class, 'index'])->name('home.index');

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

        Route::delete('questions/{question}', [questionController::class, 'destroy']);
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
    Route::resource('subjects', SubjectController::class);
    Route::resource('subjects', PanelSubjectController::class)
        ->names('subject')
        ->parameters(['subjects' => 'subject:slug'])
        ->except(['show']);

    // مستندات
    Route::resource('docs', DocController::class);
    Route::resource('docs', PanelDocController::class)
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

    Route::prefix('contact-us')->name('contactus.')->group(function () {
        Route::get('/', [ContactusController::class, 'index'])->name('index');
        Route::get('/show/{id}', [ContactusController::class, 'show'])->name('show');
        Route::post('/{id}/toggle-status', [ContactusController::class, 'toggleStatus'])->name('toggleStatus');
    });

    Route::post('/admin/resources', [ResourceController::class, 'storeOrUpdate'])
        ->name('resources.storeOrUpdate');

    Route::resource('blog', BlogController::class)->except(['show']);

    Route::resource('category', CategoryController::class)->except(['show']);

    Route::resource('tag', TagController::class)->except(['show']);

Route::delete('/activity-logs', [ActivityLogController::class, 'destroy']);
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
