<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\Book;
use App\Models\User;
use App\Services\BookService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function panel()
    {
        $approvedBooksCount = Book::where('user_id', Auth::user()->id)->Approved()->count();
        $notApprovedBooksCount = Book::where('user_id', Auth::user()->id)->notApproved()->count();
        return view('user.panel', compact('approvedBooksCount', 'notApprovedBooksCount'));
    }

    public function approvedBooks(bool $approved = true)
    {
        $bookService = new BookService();
        $books = $bookService->getBooks(true, true);
        return view('book.index', compact('books'));
    }

    public function notApprovedBooks()
    {
        $bookService = new BookService();
        $books = $bookService->getBooks(false, true);
        return view('book.index', compact('books'));
    }

    public function changePassword(ChangePasswordRequest $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->email && auth()->user()->is_admin) {
            $user = User::where('email', $request->email)->firstOrFail();
            $route = 'admin.panel';
        } else {
            $user = User::where('id', auth()->user()->id)->firstOrFail();
            $route = 'user.panel';
            if (!Hash::check($request->old_password, $user->password)) {
                throw ValidationException::withMessages([
                    'old_password' => [__('user.password_wrong')],
                ]);
            }
        }

        $updated = $user->update(['password' => Hash::make($request->password)]);
        if ($updated) {
            return redirect()->route($route)->with('changed', __('user.password_changed'));
        }

        abort(404);
    }
}
