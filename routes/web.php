<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

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

Route::group(['as' => 'book.'], function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::group(['prefix' => 'book'], function () {
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/create', [BookController::class, 'create'])->name('create');
            Route::post('/store', [BookController::class, 'store'])->name('store');
        });
        Route::get('/{book}', [BookController::class, 'show'])->name('show');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'genre', 'as' => 'genre.', 'middleware' => 'admin'], function () {
        Route::view('/create', 'genre.create')->name('create');
        Route::post('/store', [GenreController::class, 'store'])->name('store');
    });
    Route::group(['as' => 'review.', 'prefix' => 'review'], function () {
        Route::post('/{book}', [ReviewController::class, 'store'])->name('store');
    });
    Route::group(['as' => 'rating.', 'prefix' => 'rating'], function () {
        Route::post('/{book}', [RatingController::class, 'store'])->name('store');
        Route::delete('/{book}', [RatingController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__ . '/auth.php';
