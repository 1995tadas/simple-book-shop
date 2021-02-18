<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Mail\ChangeEmail;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Swift_TransportException;

class UserController extends Controller
{
    public function panel()
    {
        $approvedBooksCount = Book::where('user_id', auth()->id())
            ->approved()->count();
        $notApprovedBooksCount = Book::where('user_id', auth()->id())
            ->notApproved()->count();

        return view('user.panel', compact('approvedBooksCount', 'notApprovedBooksCount'));
    }

    public function approvedBooks()
    {
        $books = Book::where('user_id', auth()->id())
            ->approved()
            ->latest()
            ->paginate();
        $title = __('user.approved');
        return view('book.index', compact('books', 'title'));
    }

    public function notApprovedBooks()
    {

        $books = Book::where('user_id', auth()->id())
            ->notApproved()
            ->latest()
            ->paginate();
        $title = __('user.not_approved');
        return view('book.index', compact('books', 'title'));
    }

    public function changePassword(ChangePasswordRequest $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->email && auth()->user()->is_admin) {
            $user = User::where('email', $request->email)->firstOrFail();
            $route = 'admin.panel';
        } else {
            $user = User::where('id', auth()->id())->firstOrFail();
            $route = 'user.panel';
            if (!Hash::check($request->old_password, $user->password)) {
                throw ValidationException::withMessages([
                    'old_password' => [__('user.password_wrong')],
                ]);
            }
        }

        try {
            $user->update(['password' => bcrypt($request->password)]);
        } catch (\Exception $e) {
            return redirect()->route($route)->with('password_error', __('user.password_change_error'));
        }

        return redirect()->route($route)->with('password_message', __('user.password_changed'));
    }

    public function changeEmail(ChangeEmailRequest $request): \Illuminate\Http\RedirectResponse
    {
        $currentEmail = Auth::user()->email;
        try {
            Mail::to($request->new_email)->send(new ChangeEmail($currentEmail, $request->new_email));
        } catch (Swift_TransportException $e) {
            throw new Swift_TransportException('Your email credentials probably are not set up correctly');
        }

        return redirect()->route('user.panel')->with('email_success', __('user.email_send'));
    }

    public function verifyEmail(ChangeEmailRequest $request): \Illuminate\Http\RedirectResponse
    {
        $redirectRoute = redirect()->route('user.panel');

        if (!isset($request->current_email) || auth()->user()->email !== $request->current_email) {
            return $redirectRoute->with('email_error', __('user.email_match_error'));
        }

        try {
            User::where('email', $request->current_email)->update(['email' => $request->new_email]);
        } catch (\Exception $e) {
            return $redirectRoute->with('email_success', __('user.email_change_error'));
        }

        return $redirectRoute->with('email_success', __('user.email_changed'));
    }
}
