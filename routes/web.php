<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\BookController;
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
    Route::view('/', 'book.index')->name('landing');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/create', [BookController::class, 'create'])->name('create');
        Route::post('/store', [BookController::class, 'store'])->name('store');
    });
});

Route::group(['prefix' => 'genre', 'as' => 'genre.', 'middleware' => 'admin'], function () {
    Route::view('/create', 'genre.create')->name('create');
    Route::post('/store', [GenreController::class, 'store'])->name('store');
});

require __DIR__ . '/auth.php';
