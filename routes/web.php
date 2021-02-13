<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
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

Route::get('/', [BookController::class, 'index'])->name('book.index');
Route::resource('book', BookController::class)->except('index');
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
    Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::get('/panel', [AdminController::class, 'panel'])->name('panel');
        Route::get('/not-approved-books', [AdminController::class, 'notApprovedBooks'])->name('not_approved_books');
        Route::put('/approve-book/{book}', [AdminController::class, 'approveBook'])->name('approve_book');
    });
    Route::group(['as' => 'report.', 'prefix' => 'report'], function () {
        Route::get('/create/{book}', [ReportController::class, 'create'])->name('create');
        Route::post('/store', [ReportController::class, 'send'])->name('send');
    });
    Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
        Route::get('/panel', [UserController::class, 'panel'])->name('panel');
        Route::get('/approved-books', [UserController::class, 'approvedBooks'])->name('approved_books');
        Route::get('/not-approved-books', [UserController::class, 'notApprovedBooks'])->name('not_approved_books');
        Route::put('/change-password', [UserController::class, 'changePassword'])->name('change_password');
        Route::put('/change-email', [UserController::class, 'changeEmail'])->name('change_email');
        Route::get('/verify-email', [UserController::class, 'verifyEmail'])->name('verify_email');
    });
    Route::group(['as' => 'author.', 'prefix' => 'author'], function () {
        Route::get('/autocomplete', [AuthorController::class, 'autocomplete'])->name('autocomplete');
    });
});

Route::post('search/search', SearchController::class)->name('search');

require __DIR__ . '/auth.php';
