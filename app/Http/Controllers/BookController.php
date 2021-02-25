<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Book;
use App\Models\Genre;
use App\Services\BookService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(SearchRequest $request)
    {
        $books = Book::with(['authors', 'genres'])
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                Cookie::queue('search', $search);

                $query
                    ->where('title', 'like', '%' . $search . '%')
                    ->OrwhereHas('authors', function ($query) use ($search) {
                        return $query
                            ->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->approved()
            ->latest()
            ->paginate();

        return view('book.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('book.show', compact('book'));
    }

    public function create()
    {
        $genres = Genre::all('id AS value', 'title AS option');

        return view('user.book.create', compact('genres'));
    }

    public function store(BookRequest $request, BookService $bookService): \Illuminate\Http\RedirectResponse
    {
        $bookService->updateOrCreate($request);

        return redirect()->route('book.index')->with('success', __('book.wait_for_admin'));
    }

    public function edit(Book $book)
    {
        $authors = $book->authors()->pluck('name');
        $genresOld = Arr::pluck($book->genres->toArray(), 'id');
        $genres = Genre::all('id AS value', 'title AS option');
        return view('user.book.edit', compact('genres', 'genresOld', 'authors', 'book'));
    }

    public function update(BookRequest $request, Book $book, BookService $bookService): \Illuminate\Http\RedirectResponse
    {
        $bookService->updateOrCreate($request, $book);

        return redirect()->route('book.index')->with('success', __('book.updated'));
    }

    public function destroy(Book $book): \Illuminate\Http\RedirectResponse
    {
        if (auth()->user()->is_admin) {
            $redirect = redirect()->route('admin.not_approved_books');
        } else {
            $redirect = redirect()->route('book.index');
        }

        try {
            Storage::delete($book->cover);
            $book->delete();
        } catch (\Exception $e) {
            return $redirect->with('error', __('book.delete_error'));
        }

        return $redirect->with('success', __('book.delete_success'));
    }
}
