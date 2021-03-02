<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->name('api.user');

// Book api
Route::apiResource('v1/books', BookController::class)->only('index', 'show');

Route::get('book/{book}', [BookController::class, 'load'])->name('api.book.load');

// Admin stuff
Route::group(['as' => 'api.admin.', 'prefix' => 'admin', 'middleware' => 'admin:sanctum'], function () {
    Route::put('/approve-book/{book}', [AdminController::class, 'approveBook'])->name('approve_book');
});

// User stuff
Route::group(['as' => 'api.user.', 'prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {

    // Reviews
    Route::post('review/{book}', [ReviewController::class, 'store'])->name('review.store');

    // Ratings
    Route::group(['as' => 'rating.', 'prefix' => 'rating'], function () {
        Route::post('/{book}', [RatingController::class, 'store'])->name('store');
        Route::delete('/{book}', [RatingController::class, 'destroy'])->name('destroy');
    });

    // Authors
    Route::get('author/autocomplete', [AuthorController::class, 'autocomplete'])->name('author.autocomplete');
});


