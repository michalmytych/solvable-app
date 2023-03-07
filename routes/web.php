<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\RootController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\Docs\DocsController;
use App\Http\Controllers\Web\Docs\ComponentsShowcaseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [RootController::class, 'index'])->name('web_root');

Route::middleware('auth')->group(function () {

    Route::group(['prefix' => 'problems', 'as' => 'problem.'], function() {
        Route::get('/', [\App\Http\Controllers\Web\ProblemController::class, 'index'])
            ->name('index');
        Route::get('/create', [\App\Http\Controllers\Web\ProblemController::class, 'create'])
            ->name('create');
        Route::post('/store', [\App\Http\Controllers\Web\ProblemController::class, 'store'])
            ->name('store');
        Route::get('/{problem}', [\App\Http\Controllers\Web\ProblemController::class, 'show'])
            ->name('show');
    });

    Route::group(['prefix' => 'courses', 'as' => 'course.'], function() {
        Route::get('/', [\App\Http\Controllers\Web\Course\CourseController::class, 'index'])
            ->name('index');
        Route::get('/create', [\App\Http\Controllers\Web\Course\CourseController::class, 'create'])
            ->name('create');
        Route::post('/store', [\App\Http\Controllers\Web\Course\CourseController::class, 'store'])
            ->name('store');
        Route::get('/{course}', [\App\Http\Controllers\Web\Course\CourseController::class, 'show'])
            ->name('show');
        Route::get('/{course}/edit', [\App\Http\Controllers\Web\Course\CourseController::class, 'edit'])
            ->name('edit');
    });

    Route::group(['prefix' => 'groups', 'as' => 'group.'], function() {
        Route::get('/{group}', fn() => null)->name('show');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('verified')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::group(['prefix' => 'docs', 'as' => 'docs.'], function() {
        Route::get('/', [DocsController::class, 'index'])
            ->name('index');
        Route::get('components-showcase', [ComponentsShowcaseController::class, 'showcase'])
            ->name('components_showcase');
    });
});

require __DIR__.'/auth.php';
