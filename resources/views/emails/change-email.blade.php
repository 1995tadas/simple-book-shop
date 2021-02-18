@component('mail::message')
    <div>{{ __('user.email_change_mail') . ' ' . $currentEmail . ' ' . __('user.to') . ' ' . $newEmail }}</div>
    @component('mail::button', ['url' => route('user.change_email',
              ['current_email' => $currentEmail, 'new_email' => $newEmail])])
        {{ __('user.verify_email') }}
    @endcomponent

    Thanks

    {{ config('app.name') }}
@endcomponent
