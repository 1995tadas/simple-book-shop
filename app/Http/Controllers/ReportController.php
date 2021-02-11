<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Models\Book;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Support\Arr;


class ReportController extends Controller
{
    public function create(Book $book)
    {
        return view('report.create', compact('book'));
    }

    public function store(ReportRequest $request): \Illuminate\Http\RedirectResponse
    {
        $fields = Arr::add($request->validated(), 'user_id', Auth()->user()->id);
        $created = Report::create($fields);
        if ($created) {
            return redirect()->route('book.show', ['book' => Book::findOrFail($request->book_id)->slug])
                ->with('success', __('report.reported'));
        }

        abort(404);
    }

    public function show(Report $report)
    {
        $report->seen = Carbon::now();
        $report->save();
        return view('report.show', compact('report'));
    }
}
