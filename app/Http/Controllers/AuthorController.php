<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function autocomplete(Request $request): \Illuminate\Http\JsonResponse
    {
        $authors = Author::where('name', 'LIKE', $request->search . '%')->pluck('name');
        return response()->json($authors);
    }
}
