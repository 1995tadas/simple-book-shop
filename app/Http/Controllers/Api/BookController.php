<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;

class BookController extends Controller
{
    public function __construct()
    {
        request()->headers->set('Accept', 'application/json');
    }

    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $books = Book::with(['authors', 'genres'])
            ->approved()
            ->latest()
            ->paginate();

        return BookResource::collection($books);
    }

    public function show($id): BookResource
    {
        $book = Book::with(['authors', 'genres'])
            ->approved()
            ->findOrFail($id);

        return new BookResource($book);
    }

    public function load(Book $book): \Illuminate\Http\JsonResponse
    {
        $book->load('ratings');
        $ratings = $book->ratings;
        $userRating = null;
        if (auth()->check() && $ratings->isNotEmpty()) {
            $userRating = optional(
                $ratings->where('user_id', auth()->id())->first())
                ->rate;
        }

        $reviews = $book->reviews()->with('users')->latest()->simplePaginate(10);
        $averageRating = $ratings->IsEmpty() ? 0 : $ratings->avg('rate');
        $data = [
            'book' => $book,
            'authors' => $book->authors,
            'genres' => $book->genres,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'ratersCount' => $ratings->count(),
            'userRating' => $userRating
        ];

        return response()->json($data);
    }
}
