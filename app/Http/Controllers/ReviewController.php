<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function store(ReviewRequest $request, Book $book)
    {
        $created = Review::create([
            'content' => $request->content,
            'book_id' => $book->id,
            'user_id' => Auth::user()->id
        ]);

        if (!$created) {
            return response('failed', 422);
        }

        return response('created', 201);
    }
}
