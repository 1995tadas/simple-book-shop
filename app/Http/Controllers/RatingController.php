<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(RatingRequest $request, Book $book)
    {
        $created = Rating::updateOrCreate(
            ['book_id' => $book->id, 'user_id' => Auth::user()->id],
            ['rate' => $request->rate]
        );
        if (!$created) {
            return response('failed', 422);
        }

        return response('created', 201);
    }

    public function destroy(Book $book)
    {
        $deleted = Rating::where('book_id', $book->id)->where('user_id', Auth::user()->id)->delete();
        if (!$deleted) {
            return response('failed', 422);
        }

        return response('deleted', 204);
    }

}
