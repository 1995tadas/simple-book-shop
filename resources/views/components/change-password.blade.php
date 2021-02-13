@props(['admin' => false])
<form class="pl-3 mt-1 block w-full sm:w-2/6" action="{{route('user.change_password')}}" method="post">
    @if(session()->has("password_message"))
        <x-success>
            {{ session()->get("password_message") }}
        </x-success>
    @endif
    <x-auth-validation-errors class="mb-4" :errors="$errors->change_password"/>
    @csrf
    @method('put')

    <div class="mt-1">
        @if(Auth()->user()->is_admin && $admin)
            <x-label for="email" :value="__('admin.user').' '.__('auth_views.email').'*'" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                     required>
            </x-input>
        @else
            <x-label for="old_password" :value="__('auth_views.password').'*'"/>
            <x-input id="old_password" class="block mt-1 w-full" type="password" name="old_password"
                     minlength="8"
                     required>
            </x-input>
        @endif
    </div>
    <div class="mt-1">
        <x-label for="password" :value="__('auth_views.new_password').'*'"/>
        <x-input id="password" class="block mt-1 w-full" type="password" name="password"
                 minlength="8"
                 required>
        </x-input>
    </div>
    <div class="mt-1">
        <x-label for="password_confirmation" :value="__('auth_views.confirm_password').'*'"/>
        <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                 name="password_confirmation"
                 minlength="8"
                 required>
        </x-input>
    </div>
    <x-button class="mt-4">
        {{ __('auth_views.change_password') }}
    </x-button>
</form>
