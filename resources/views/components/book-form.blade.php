@props(['title', 'action', 'method', 'buttonTitle', 'genres'])

<x-form-card>
    <x-slot name="title">
        {{$title}}
    </x-slot>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors"/>
    <form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if(strtolower($method) !== "post")
        @method($method)
    @endif
    <!-- Book Title -->
        <div>
            <x-label for="book" :value="__('book.title')"/>

            <x-input id="book" class="block mt-1 w-full" type="text" name="title" :value="old('title')" maxlength="60"
                     required
                     autofocus/>
        </div>
        <!-- Book author -->
        <div class="mt-4">
            <x-label for="author" :value="__('book.author')"/>
            <input-repeater id="author" type="text" name="author"></input-repeater>
        </div>
        <div class="mt-4">
            <x-label for="price">
                {{__('book.price')}} (€)
            </x-label>
            <x-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price') ?? 0"/>
        </div>
        @if(strtolower($method) !== "post")
            <div class="mt-4">
                <x-label for="discount">
                    {{__('book.discount')}} (%)
                </x-label>
                <x-input id="discount" class="block mt-1 w-full" type="number" name="discount"
                         :value="old('discount') ?? '0'" min="0" max="100"/>
            </div>
        @endif
        <div class="mt-4">
            <x-label for="genres" :value="__('book.genres')"/>
            <select-repeater :options="{{$genres}}" id="genres" name="genres"></select-repeater>
        </div>
        <div class="mt-4">
            <x-label for="description" :value="__('book.description')"/>
            <x-textarea id="description" class="block mt-1 w-full" name="description" maxlength="255" required>
                {{old('description')}}
            </x-textarea>
        </div>
        <div class="mt-4">
            <x-label for="cover" :value="__('book.cover')"/>
            <x-input type="file" id="cover" name="cover" accept="image/png, image/jpeg, image/jpg" required/>
        </div>
        <div class="mt-4">
            <x-button>{{$buttonTitle}}</x-button>
        </div>
    </form>
</x-form-card>
