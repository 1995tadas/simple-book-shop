<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Book;
use App\Models\Report;


class ReportController extends Controller
{
    public function create(Book $book)
    {
        return view('report.create', compact('book'));
    }

    public function store(ReportRequest $request): \Illuminate\Http\RedirectResponse
    {
        $created = Report::create($request->validated());
        if ($created) {
            return redirect()->route('book.show', ['book' => Book::find($request->book_id)->slug])
                ->with('success', __('report.reported'));
        }

        abort(404);
    }
}
