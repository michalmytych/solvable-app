<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Course\CourseController;
use App\Http\Controllers\Api\Problem\ProblemController;
use App\Http\Controllers\Api\Solution\SolutionController;

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

// Public routes
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'solutions', 'as' => 'solution.'], function () {
        Route::get('/', [SolutionController::class, 'all'])->name('all');
        Route::post('/{problem}/commit', [SolutionController::class, 'commit'])->name('commit');
    });

    Route::group(['prefix' => 'problems', 'as' => 'problem.'], function () {
        Route::get('/', [ProblemController::class, 'allByUser'])->name('all_by_user');
        Route::post('/{group}', [ProblemController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'courses', 'as' => 'course.'], function () {
        Route::get('/', [CourseController::class, 'all'])->name('all');
        Route::post('/{course}', [CourseController::class, 'store'])->name('store');
        Route::put('/{course}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [CourseController::class, 'delete'])->name('delete');
    });
});

