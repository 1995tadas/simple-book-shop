<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function store(ReviewRequest $request, Book $book)
    {
        $user = Auth::user();

        try {
            $review = Review::create([
                'content' => $request->content,
                'book_id' => $book->id,
                'user_id' => $user->id
            ]);
        } catch (\Exception $e) {
            return response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response()->json([
            'created_at' => $review->created_at,
            'user' => $user->name,
            'content' => $review->content
        ], Response::HTTP_CREATED);
    }
}
