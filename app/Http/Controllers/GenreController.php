<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;

class GenreController extends Controller
{
    public function store(GenreRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            Genre::create($request->validated());
        } catch (\Exception $e) {
            return redirect()->route('admin.genre.create')
                ->with('error', __('genre.error'));
        }

        return redirect()->route('admin.genre.create')
            ->with('success', __('genre.success'));
    }
}
