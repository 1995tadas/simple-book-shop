<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Book;

class SearchController extends Controller
{
    public function search(SearchRequest $request)
    {
        session()->flash('search', $request->search);

        $books = Book::where('title', 'like', '%' . $request->search . '%')
            ->OrwhereHas('authors', function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })->simplePaginate(25);
        return view('book.index', compact('books'));
    }
}
