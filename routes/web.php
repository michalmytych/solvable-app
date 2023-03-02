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

    // @todo - add group with prefix
    Route::get('/problems', [\App\Http\Controllers\Web\ProblemController::class, 'index'])
        ->name('problem.index');
    Route::get('/problems/create', [\App\Http\Controllers\Web\ProblemController::class, 'create'])
        ->name('problem.create');
    Route::post('/problems/store', [\App\Http\Controllers\Web\ProblemController::class, 'store'])
        ->name('problem.store');
    Route::get('/problems/{problem}', [\App\Http\Controllers\Web\ProblemController::class, 'show'])
        ->name('problem.show');

    // @todo - add group with prefix
    Route::get('/courses', [\App\Http\Controllers\Web\Course\CourseController::class, 'index'])
        ->name('course.index');
    Route::get('/courses/create', [\App\Http\Controllers\Web\Course\CourseController::class, 'create'])
        ->name('course.create');
    Route::post('/courses/store', [\App\Http\Controllers\Web\Course\CourseController::class, 'store'])
        ->name('course.store');
    Route::get('/courses/{course}', [\App\Http\Controllers\Web\Course\CourseController::class, 'show'])
        ->name('course.show');
    Route::get('/courses/{course}/edit', [\App\Http\Controllers\Web\Course\CourseController::class, 'edit'])
        ->name('course.edit');

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
