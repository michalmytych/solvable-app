<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\RootController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\DashboardController;
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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('verified')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::group(['prefix' => 'docs', 'as' => 'docs.'], function() {
        Route::get('components-showcase', [ComponentsShowcaseController::class, 'index'])
            ->name('components_showcase');
    });
});

require __DIR__.'/auth.php';
