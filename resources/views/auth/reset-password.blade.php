<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div class="w-3/12 block m-auto">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
            </div>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('user.email')"/>

                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                         :value="old('email', $request->email)" required autofocus/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('user.password')"/>

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required/>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('user.confirm_password')"/>

                <x-input id="password_confirmation" class="block mt-1 w-full"
                         type="password"
                         name="password_confirmation" required/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{__('user.reset_password')}}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
