<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto">
        <!-- Page Heading -->
        <header
            class="bg-white py-6 px-1 sm:px-6 lg:px-8 shadow flex items-center justify-center md:justify-between flex-wrap">
            <x-input id="search" class="block p-1 mb-1 sm:mb-0" type="text" name="search" :value="old('search')"
                     required/>
            <div class="flex whitespace-nowrap justify-center md:justify-between px-5 flex-wrap">
                @guest()
                    <a class="bg-white hover:opacity-50 py-1 px-5 border-2 border-black text-black rounded"
                       href="{{ route('login') }}">
                        <button class="focus:outline-none" type="button">{{__('additional.sign_in')}}
                        </button>
                    </a>
                    <a class="bg-black hover:opacity-50 py-1 px-5 border-2 border-black text-white rounded ml-2"
                       href="{{ route('register') }}">
                        <button class="focus:outline-none" type="button">
                            {{__('additional.sign_up')}}
                        </button>
                    </a>
                @else
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('genre.create') }}">
                            <x-header-button class="bg-white text-black ml-2">{{__('genre.new')}}</x-header-button>
                        </a>
                    @endif
                    <a href="{{ route('book.create') }}">
                        <x-header-button class="bg-white text-black ml-2">{{__('book.new')}}</x-header-button>
                    </a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf()
                        <x-header-button class="bg-black text-white ml-2">{{__('additional.log_out')}}</x-header-button>
                    </form>
                @endguest
            </div>
        </header>

        <!-- Page Content -->
        <main id="app">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
