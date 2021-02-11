<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function getBooks(bool $approved = true, bool $user = false)
    {
        $books = new Book();
        if ($user) {
            $books = $books->where('user_id', auth()->user()->id);
        }

        if ($approved) {
            $books = $books->approved();
        } else {
            $books = $books->notApproved();
        }

        return $books->latest()->paginate(25);
    }
}
