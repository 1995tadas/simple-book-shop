@props(['title','action', 'method','buttonTitle'])

<x-form-card>
    <x-slot name="title">
        {{$title}}
    </x-slot>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

    @if(session()->has('success'))
        <x-success>
            {{ session()->get('success') }}
        </x-success>
    @endif
    <form method="post" action="{{ $action }}">
    @csrf
    @if(strtolower($method) !== "post")
        @method($method)
    @endif
    <!-- Book Title -->
        <div>
            <x-label for="genre" :value="__('genre.title')"/>

            <x-input id="genre" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required
                     autofocus/>
        </div>
        <div class="mt-4">
            <x-button>{{$buttonTitle}}</x-button>
        </div>
    </form>
</x-form-card>
