<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
            <div>
                <x-label for="name" :value="__('auth_views.name')"/>

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                         autofocus/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('auth_views.email')"/>

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required/>
            </div>

            <!-- Passwords -->
            <toggle-password-visibility
                :inputs="{{ json_encode([__('auth_views.password') =>'password',
                         __('auth_views.confirm_password') => 'password_confirmation'])}}"
                checkbox-label="{{__('book.show_passwords')}}"
            >

            </toggle-password-visibility>

            <!-- Date Of Birth -->
            <div class="mt-4">
                <x-label for="date_of_birth" :value="__('auth_views.date_of_birth')"/>
                @php
                    $yesterdayCarbon = Carbon\Carbon::yesterday();
                    $yesterdayDate = $yesterdayCarbon->format('Y-m-d');
                @endphp
                <x-input id="date_of_birth" class="block mt-1 w-full"
                         type="date"
                         name="date_of_birth"
                         min="{{ $yesterdayCarbon->subCenturies(1)->format('Y-m-d') }}"
                         max="{{ $yesterdayDate }}"
                         value="{{ $yesterdayDate }}"
                         required/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('auth_views.registered') }}
                </a>

                <x-button class="ml-4">
                    {{ __('auth_views.register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
