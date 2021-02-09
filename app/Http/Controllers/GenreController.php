<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;

class GenreController extends Controller
{
    public function store(GenreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $created = Genre::create($request->validated());
        if($created){
            return redirect()->back()->with('success', __('genre.success'));
        }

        abort(404);
    }
}