<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Report;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function panel()
    {
        $data = [
            'approvedBooksCount' => Book::approved()->count(),
            'notApprovedBooksCount' => Book::notApproved()->count(),
            'newReportsCount' => Report::new()->count(),
            'allReportsCount' => Report::count(),
        ];

        return view('admin.panel', $data);
    }

    public function notApprovedBooks()
    {
        $books = Book::with(['authors', 'genres'])->notApproved()->latest()->get();
        $hidePagination = true;
        return view('book.index', compact('books', 'hidePagination'));
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

    public function reports(bool $new = false)
    {
        $reports = Report::with('user', 'book');
        if ($new) {
            $reports = $reports->new();
        }

        $reports = $reports->latest()->paginate(25);
        return view('report.index', compact('reports'));
    }

    public function newReports()
    {
        return $this->reports(true);
    }
}
