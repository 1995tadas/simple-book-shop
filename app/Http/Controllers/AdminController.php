<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function panel()
    {
        $data = [
            'approvedBooksCount' => Book::approved()->count(),
            'notApprovedBooksCount' => Book::notApproved()->count(),
        ];

        return view('admin.panel', $data);
    }

    public function notApprovedBooks()
    {
        $books = Book::notApproved()->latest()->paginate(25);
        return view('book.index', compact('books'));
    }

    public function approveBook(Book $book): \Illuminate\Http\RedirectResponse
    {
        if ($book->approved === null) {
            $updated = $book->update(['approved' => Carbon::now()]);
            if ($updated) {
                return redirect()->route('admin.not_approved_books')
                    ->with('success', __('admin.approved_success'));
            }
        }

        abort(404);
    }
}
