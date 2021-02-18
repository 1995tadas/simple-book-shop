@props(['admin' => false])
<form class="pl-3 mt-2 block w-full sm:w-2/6" action="{{ route('user.change_email') }}" method="post">
    @if(session()->has("email_message"))
        <x-success>
            {{ session()->get("email_message") }}
        </x-success>
    @endif
    <x-auth-validation-errors class="mb-4" :errors="$errors->change_email"/>
    @csrf
    @method('put')
    <div class="mt-1">
        <x-label for="new_email" :value="__('user.new_email').'*'"/>
        <x-input id="new_email" class="block mt-1 w-full" type="email" name="new_email" :value="old('new_email')"
                 required>
        </x-input>
    </div>
    <x-button class="mt-4">
        {{ __('user.change_email') }}
    </x-button>
</form>
