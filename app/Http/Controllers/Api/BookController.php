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

        return BookResource::setMode('books')::collection($books);
    }

    public function show($id): BookResource
    {
        $book = Book::with(['authors', 'genres'])
            ->approved()
            ->findOrFail($id);

        return new BookResource($book);
    }
}
