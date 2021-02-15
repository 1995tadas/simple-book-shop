<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Mail\ChangeEmail;
use App\Models\Book;
use App\Models\User;
use App\Services\BookService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function panel()
    {
        $approvedBooksCount = Book::where('user_id', Auth::user()->id)->Approved()->count();
        $notApprovedBooksCount = Book::where('user_id', Auth::user()->id)->notApproved()->count();
        $user = Auth()->user();
        return view('user.panel', compact('approvedBooksCount', 'notApprovedBooksCount', 'user'));
    }

    public function approvedBooks()
    {
        $bookService = new BookService();
        $books = $bookService->getBooks(true, true);
        $title = __('user.approved');
        return view('book.index', compact('books', 'title'));
    }

    public function notApprovedBooks()
    {
        $bookService = new BookService();
        $books = $bookService->getBooks(false, true);
        $title = __('user.not_approved');
        return view('book.index', compact('books', 'title'));
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
            return redirect()->route($route)->with('password_message', __('user.password_changed'));
        }

        abort(404);
    }

    public function changeEmail(ChangeEmailRequest $request): \Illuminate\Http\RedirectResponse
    {
        $currentEmail = Auth::user()->email;
        Mail::to($request->new_email)->send(new ChangeEmail($currentEmail, $request->new_email));
        return redirect()->route('user.panel')->with('email_message', __('user.email_send'));
    }

    public function verifyEmail(ChangeEmailRequest $request): \Illuminate\Http\RedirectResponse
    {
        if (isset($request->current_email) && auth()->user()->email === $request->current_email) {
            $updated = User::where('email', $request->current_email)->update(['email' => $request->new_email]);
            if ($updated) {
                return redirect()->route('user.panel')->with('email_message', __('user.email_changed'));
            }
        }

        abort(404);
    }
}
