<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function create()
    {
        $genres = Genre::all('id AS value', 'title AS option');
        return view('book.create', compact('genres'));
    }

    public function store(BookRequest $request)
    {
        $coverPath = $request->file('cover')->store('covers');
        $validatedRequest = $request->validated();
        $validatedRequest['cover'] = $coverPath;
        $validatedRequest['user_id'] = Auth::user()->id;
        $created = Book::create($validatedRequest);

        if ($created) {
            return redirect()->route('book.index');
        }

        abort(404);
    }
}
