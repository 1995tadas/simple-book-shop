<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Genre;
use App\Services\BookService;
use Illuminate\Support\Arr;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
        $this->middleware('author.admin')->only(['edit', 'update', 'destroy']);
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $books = Book::with(['authors', 'genres'])->approved()
            ->latest()->simplePaginate(25);
        return view('book.index', compact('books'));
    }

    public function show(Book $book): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $ratings = $book->ratings;
        $user_rating = null;
        if ($ratings->isNotEmpty() && Auth()->check()) {
            $rated = $ratings->where('user_id', Auth()->user()->id)->first();
            if ($rated) {
                $user_rating = $rated->rate;
            }
        }

        $data = [
            'book' => $book,
            'authors' => $book->authors,
            'genres' => $book->genres,
            'reviews' => $book->reviews()->latest()->simplePaginate(3),
            'ratings' => $ratings->IsEmpty() ? 0 : $ratings->avg('rate'),
            'user_rating' => $user_rating
        ];
        return view('book.show', $data);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $genres = Genre::all('id AS value', 'title AS option');
        return view('book.create', compact('genres'));
    }

    public function store(BookRequest $request): \Illuminate\Http\RedirectResponse
    {
        $bookService = new BookService();
        $bookService->storeOrUpdate($request);
        return redirect()->route('book.index')->with('success', __('book.wait_for_admin'));
    }

    public function edit(Book $book): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $authors = $book->authors()->pluck('name');
        $genresOld = Arr::pluck($book->genres->toArray(), 'id');
        $genres = Genre::all('id AS value', 'title AS option');
        return view('book.edit', compact('genres', 'genresOld', 'authors', 'book'));
    }

    public function update(BookRequest $request, Book $book): \Illuminate\Http\RedirectResponse
    {
        $bookService = new BookService();
        $bookService->storeOrUpdate($request, $book);
        return redirect()->route('book.index')->with('success', __('book.updated'));
    }

    public function destroy(Book $book): \Illuminate\Http\RedirectResponse
    {
        try {
            $deleted = $book->delete();
        } catch (\Exception $e) {
            throw new \ErrorException('Something went wrong while deleting book');
        }

        if ($deleted) {
            if (auth()->user()->is_admin) {
                $redirect = redirect()->route('admin.not_approved_books');
            } else {
                $redirect = redirect()->route('book.index');
            }

            return $redirect->with('success', __('book.delete_success'));
        }

        abort(422);
    }
}
