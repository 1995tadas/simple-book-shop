<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Mail\Report;
use App\Models\Book;
use Illuminate\Support\Facades\Mail;


class ReportController extends Controller
{
    public function create(Book $book)
    {
        return view('user.report.create', compact('book'));
    }

    public function send(ReportRequest $request): \Illuminate\Http\RedirectResponse
    {
        $book = Book::findOrFail($request->book_id);
        $bookLink = route('book.show', ['book' => $book->slug]);
        $data = [
            'content' => $request->content,
            'bookLink' => $bookLink,
            'bookTitle' => $book->title,
            'from' => auth()->user()->email
        ];

        Mail::send(new Report($data));
        return redirect($bookLink)->with('success', __('report.reported'));
    }
}
