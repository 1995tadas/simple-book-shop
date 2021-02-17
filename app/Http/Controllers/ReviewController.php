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
        $user = Auth::user();

        $review = Review::create([
            'content' => $request->content,
            'book_id' => $book->id,
            'user_id' => $user->id
        ]);

        if (!$review) {
            return response('failed', 422);
        }

        return response()->json([
            'created_at' => $review->created_at,
            'user' => $user->name,
            'content' => $review->content
        ], 201);
    }
}
