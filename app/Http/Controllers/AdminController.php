<?php

namespace App\Http\Controllers;

use App\Models\Book;

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
        $title = __('admin.admin') . ' ' . __('admin.not_approved');
        return view('book.index', compact('books', 'title'));
    }

    public function approveBook(Book $book): \Illuminate\Http\RedirectResponse
    {
        try {
            $book->update(['approved_at' => now()]);
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.not_approved_books')
                ->with('error', __('admin.approved_error'));
        }

        return redirect()
            ->route('admin.not_approved_books')
            ->with('success', __('admin.approved_success'));
    }
}
