<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Response;

class AdminController extends Controller
{

    public function __construct()
    {
        request()->headers->set('Accept', 'application/json');
    }

    public function approveBook(Book $book)
    {
        try {
            $book->update(['approved_at' => now()]);
        } catch (\Exception $e) {
            return response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
