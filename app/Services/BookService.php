<?php

namespace App\Services;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Str;

class BookService
{
    public function updateOrCreate(BookRequest $request, Book $book = null): void
    {
        $request = $this->prepareBook($request);
        if (!$book) {
            $book = Book::create($request);
        } else {
            $book->update($request);
        }

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

        $stringService = new StringService();
        $slug = $stringService->uniqueSlug(new Book(), $request->title);

        $validatedRequest['slug'] = $slug;
        return $validatedRequest;
    }
}
