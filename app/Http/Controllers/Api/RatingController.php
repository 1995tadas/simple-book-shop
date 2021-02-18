<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\Response;

class RatingController extends Controller
{
    public function store(RatingRequest $request, Book $book)
    {
        try {
            Rating::updateOrCreate(
                ['book_id' => $book->id, 'user_id' => auth()->id()],
                ['rate' => $request->rate]
            );
        } catch (\Exception $e) {
            return response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response(null, Response::HTTP_CREATED);
    }

    public function destroy(Book $book)
    {
        try {
            Rating::where('book_id', $book->id)->where('user_id', auth()->id())->delete();
        } catch (\Exception $e) {
            return response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
