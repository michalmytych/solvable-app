<?php

use App\Http\Controllers\Api\ProblemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\SolutionController;

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
        Route::get('/test-jdoodle', [SolutionController::class, 'testJdoodle'])->name('test_jdoodle');

        Route::get('/{solution}', [SolutionController::class, 'find'])->name('find');
        Route::post('/{problem}/commit', [SolutionController::class, 'commit'])->name('commit');
    });

    Route::group(['prefix' => 'problems', 'as' => 'problem.'], function () {
        Route::get('/', [ProblemController::class, 'findByUser'])->name('find_by_user');
        Route::post('/', [ProblemController::class, 'createWithRelations'])->name('create_with_relations');
        Route::get('/{problem}/solutions', [SolutionController::class, 'findByProblemAndUser'])->name('find_by_problem_and_user');
    });
});

