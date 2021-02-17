<?php

namespace App\Services;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookService
{
    public function getBooks(bool $approved = true, bool $user = false)
    {
        $books = new Book();
        if ($user) {
            $books = $books->where('user_id', auth()->user()->id);
        }

        if ($approved) {
            $books = $books->approved();
        } else {
            $books = $books->notApproved();
        }

        return $books->latest()->paginate(25);
    }

    public function storeOrUpdate(BookRequest $request, Book $book = null): bool
    {
        $request = $this->prepareBook($request);
        if (!$book) {
            $book = Book::create($request);
        } else {
            $book = tap($book)->update($request);
        }

        if ($book) {
            $createdAuthors = [];
            foreach ($request['authors'] as $authorName) {
                if ($authorName !== null) {
                    $authorExist = Author::where('name', $authorName)->first();
                    if ($authorExist) {
                        $createdAuthors[] = $authorExist->id;
                    } else {
                        $createdAuthors[] = Author::create(['name' => $authorName])->id;
                    }
                }
            }

            $book->authors()->sync($createdAuthors);
            $book->genres()->sync($request['genres']);

            return true;
        }

        abort(404);
    }

    private function prepareBook(BookRequest $request): array
    {
        $validatedRequest = $request->validated();
        $imageService = new ImageService();
        if ($request->hasFile('cover')) {
            $path = $imageService->crop($request->file('cover'), 'covers/', 600, 1000);
            $validatedRequest['cover'] = $path;
        }

        $validatedRequest['user_id'] = auth()->id();
        $validatedRequest['slug'] = Str::slug($request->title);
        return $validatedRequest;
    }
}
