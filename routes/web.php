<?php

use App\Http\Controllers\AdminController;
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

Route::group(['as' => 'book.'], function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::group(['prefix' => 'book'], function () {
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/create', [BookController::class, 'create'])->name('create');
            Route::post('/store', [BookController::class, 'store'])->name('store');
            Route::group(['middleware' => 'author.admin'], function () {
                Route::delete('/{book}', [BookController::class, 'destroy'])->name('destroy');
                Route::get('edit/{book}', [BookController::class, 'edit'])->name('edit');
                Route::put('/{book}', [BookController::class, 'update'])->name('update');
            });
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
    Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
        Route::get('/panel', [AdminController::class, 'panel'])->name('panel');
        Route::get('/not-approved-books', [AdminController::class, 'notApprovedBooks'])->name('not_approved_books');
        Route::put('/approve-book/{book}', [AdminController::class, 'approveBook'])->name('approve_book');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/new-reports', [AdminController::class, 'newReports'])->name('new_reports');
    });
    Route::group(['as' => 'report.', 'prefix' => 'report'], function () {
        Route::get('/create/{book}', [ReportController::class, 'create'])->name('create');
        Route::post('/store', [ReportController::class, 'store'])->name('store');
        Route::get('/show/{report}', [ReportController::class, 'show'])
            ->middleware('admin')->name('show');
    });
    Route::group(['as' => 'user.', 'prefix' => 'user'], function () {
        Route::get('/panel', [UserController::class, 'panel'])->name('panel');
        Route::get('/approved-books', [UserController::class, 'approvedBooks'])->name('approved_books');
        Route::get('/not-approved-books', [UserController::class, 'notApprovedBooks'])->name('not_approved_books');
    });
});

Route::post('search/search', [SearchController::class, 'search'])->name('search');

require __DIR__ . '/auth.php';
