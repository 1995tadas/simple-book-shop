<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(RatingRequest $request, Book $book): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
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

    public function destroy(Book $book): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $deleted = Rating::where('book_id', $book->id)->where('user_id', Auth::user()->id)->delete();
        if (!$deleted) {
            return response('failed', 422);
        }

        return response('deleted', 204);
    }
}
