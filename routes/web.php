<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReportController;
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

// Authenticated routes
Route::group(['middleware' => 'auth'], function () {

    // Admin stuff
    Route::group(['middleware' => 'admin', 'as' => 'admin.', 'prefix' => 'admin'], function () {

        // Admin panel routes
        Route::get('/panel', [AdminController::class, 'panel'])->name('panel');
        Route::get('/not-approved-books', [AdminController::class, 'notApprovedBooks'])->name('not_approved_books');

        // Genres
        Route::group(['prefix' => 'genre', 'as' => 'genre.'], function () {
            Route::view('/create', 'admin.genre.create')->name('create');
            Route::post('/store', [GenreController::class, 'store'])->name('store');
        });
    });

    // User stuff
    Route::group(['as' => 'user.', 'prefix' => 'user'], function () {

        // User panel routes
        Route::get('/panel', [UserController::class, 'panel'])->name('panel');
        Route::get('/approved-books', [UserController::class, 'approvedBooks'])->name('approved_books');
        Route::get('/not-approved-books', [UserController::class, 'notApprovedBooks'])->name('not_approved_books');
        Route::put('/change-password', [UserController::class, 'changePassword'])->name('change_password');
        Route::put('/change-email', [UserController::class, 'changeEmail'])->name('change_email');
        Route::get('/verify-email', [UserController::class, 'verifyEmail'])->name('verify_email');

        // Books
        Route::resource('book', BookController::class)->only(['create', 'store']);
        Route::resource('book', BookController::class)->only(['edit', 'update', 'destroy'])
            ->middleware('author.admin')->parameters(['book' => 'book:id']);

        // Reports
        Route::group(['as' => 'report.', 'prefix' => 'report'], function () {
            Route::get('/create/{book}', [ReportController::class, 'create'])->name('create');
            Route::post('/store/{book}', [ReportController::class, 'send'])->name('send');
        });
    });
});

// Unauthenticated books
Route::get('/', [BookController::class, 'index'])->name('book.index');
Route::get('book/{book}', [BookController::class, 'show'])->name('book.show');

require __DIR__ . '/auth.php';
