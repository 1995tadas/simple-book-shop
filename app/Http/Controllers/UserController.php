<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\BookService;

class UserController extends Controller
{
    public function panel()
    {
        return view('user.panel');
    }

    public function approvedBooks(bool $approved = true)
    {
        $bookService = new BookService();
        $books = $bookService->getBooks(true, true);
        return view('book.index', compact('books'));
    }

    public function notApprovedBooks()
    {
        $bookService = new BookService();
        $books = $bookService->getBooks(false, true);
        return view('book.index', compact('books'));
    }
}
