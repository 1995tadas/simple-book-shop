<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\BookGenre;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['authors', 'genres'])->latest()->simplePaginate(25);
        return view('book.index', compact('books'));
    }

    public function show(Book $book)
    {
        $ratings = $book->ratings;
        $user_rating = null;
        if ($ratings->isNotEmpty()) {
            $rated = $ratings->where('user_id', Auth()->user()->id)->first();
            if ($rated) {
                $user_rating = $rated->rate;
            }
        }

        $data = [
            'book' => $book,
            'authors' => $book->authors,
            'genres' => $book->genres,
            'ratings' => $ratings->IsEmpty() ? 0 : $ratings->avg('rate'),
            'user_rating' => $user_rating
        ];
        return view('book.show', $data);
    }

    public function create()
    {
        $genres = Genre::all('id AS value', 'title AS option');
        return view('book.create', compact('genres'));
    }

    public function store(BookRequest $request): \Illuminate\Http\RedirectResponse
    {
        $imageService = new ImageService();
        $path = $imageService->crop($request->file('cover'), 'covers/', 600, 1000);
        $validatedRequest = $request->validated();
        $validatedRequest['cover'] = $path;
        $validatedRequest['user_id'] = Auth::user()->id;
        $validatedRequest['slug'] = Str::of($request->title)->slug('-');
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
