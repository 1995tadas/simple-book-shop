<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\BookGenre;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['authors', 'genres'])->simplePaginate(25);
        return view('book.index', compact('books'));
    }

    public function create()
    {
        $genres = Genre::all('id AS value', 'title AS option');
        return view('book.create', compact('genres'));
    }

    public function store(BookRequest $request): \Illuminate\Http\RedirectResponse
    {
        $coverPath = $request->file('cover')->store('covers');
        $validatedRequest = $request->validated();
        $validatedRequest['cover'] = $coverPath;
        $validatedRequest['user_id'] = Auth::user()->id;
        $book = Book::create($validatedRequest);

        if ($book) {
            foreach ($validatedRequest['authors'] as $author) {
                if ($author !== null) {
                    Author::create([
                        'name' => $author,
                        'book_id' => $book->id
                    ]);
                }
            }

            foreach ($validatedRequest['genres'] as $genre) {
                BookGenre::create([
                    'book_id' => $book->id,
                    'genre_id' => $genre
                ]);
            }

            return redirect()->route('book.index');
        }

        abort(404);
    }
}
