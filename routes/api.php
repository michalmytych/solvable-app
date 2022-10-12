<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Course\CourseController;
use App\Http\Controllers\Api\Problem\ProblemController;
use App\Http\Controllers\Api\Solution\SolutionController;
use App\Models\CodeLanguage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'solutions', 'as' => 'solution.'], function () {
        Route::get('/', [SolutionController::class, 'all'])->name('all');
        Route::get('/{solution}', [SolutionController::class, 'find'])->name('find');
        Route::post('/{problem}/commit', [SolutionController::class, 'commit'])->name('commit');
    });

    Route::group(['prefix' => 'problems', 'as' => 'problem.'], function () {
        Route::get('/', [ProblemController::class, 'all'])->name('all');
        Route::get('/{problem}', [ProblemController::class, 'find'])->name('find');
        Route::post('/{group}', [ProblemController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'courses', 'as' => 'course.'], function () {
        Route::get('/', [CourseController::class, 'all'])->name('all');
        Route::post('/{course}', [CourseController::class, 'store'])->name('store');
        Route::put('/{course}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [CourseController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'courses', 'as' => 'course.'], function () {
        Route::get('/', [CourseController::class, 'all'])->name('all');
        Route::post('/{course}', [CourseController::class, 'store'])->name('store');
        Route::put('/{course}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [CourseController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'code-languages', 'as' => 'code_language.'], function () {
        Route::get('/', function() {  return CodeLanguage::all(); })->name('all');
    });
});

