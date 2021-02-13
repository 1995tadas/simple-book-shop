<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Book;

class SearchController extends Controller
{
    public function __invoke(SearchRequest $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        session()->flash('search', $request->search);

        $books = Book::where('title', 'like', '%' . $request->search . '%')->approved()
            ->OrwhereHas('authors', function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })->simplePaginate(25);
        return view('book.index', compact('books'));
    }
}
