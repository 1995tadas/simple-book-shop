@props(['title', 'action', 'method', 'buttonTitle', 'genres','fieldGenres',
'fieldTitle', 'fieldAuthors', 'fieldPrice', 'fieldDiscount','fieldDescription'])

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
            <x-label for="book" :value="__('book.title').'*'"/>

            <x-input id="book" class="block mt-1 w-full" type="text" name="title"
                     value="{{ old('title') ? old('title') : (isset($fieldTitle) ? $fieldTitle: '') }}"
                     maxlength="60"
                     required
                     autofocus>
            </x-input>
        </div>
        <!-- Book author -->
        <div class="mt-4">
            <x-label for="authors-1" :value="__('book.authors').'*'"/>
            <input-repeater
                id="authors" type="text" name="authors"
                auto-complete-route="{{ route('user.author.autocomplete') }}"
                @if(old('authors'))
                :values="{{ json_encode(old('authors')) }}"
                @elseif(isset($fieldAuthors))
                :values="{{ json_encode($fieldAuthors) }}"
                @endif
            ></input-repeater>
        </div>
        <div class="mt-4">
            <x-label for="price">
                {{ __('book.price') }} (€)
            </x-label>
            <x-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price"
                     :value="old('price') ? old('price') : (isset($fieldPrice) ? $fieldPrice: 0)"/>
        </div>
        @admin
            <div class="mt-4">
                <x-label for="discount">
                    {{ __('book.discount') }} (%)
                </x-label>
                <x-input id="discount" class="block mt-1 w-full" type="number" name="discount"
                         :value="old('discount') ? old('discount') : (isset($fieldDiscount) ? $fieldDiscount: 0)"
                         min="0" max="100"/>
            </div>
        @endadmin
        <div class="mt-4">
            <x-label for="genres-1" :value="__('book.genres').'*'"/>
            <select-repeater
                @if(old('genres'))
                :values="{{ json_encode(old('genres')) }}"
                @elseif(isset($fieldGenres))
                :values="{{ json_encode($fieldGenres) }}"
                @endif
                :options="{{ $genres }}" id="genres" name="genres"></select-repeater>
        </div>
        <div class="mt-4">
            <x-label for="description" :value="__('book.description').'*'"/>
            <x-textarea id="description" class="block mt-1 w-full" name="description" maxlength="255" required>
                {{ old('description') ? old('description') : (isset($fieldDescription) ? $fieldDescription : '') }}
            </x-textarea>
        </div>
        <div class="mt-4">
            <x-label for="cover" :value="__('book.cover')"/>
            <x-input type="file" id="cover" name="cover" accept="image/png, image/jpeg, image/jpg"/>
        </div>
        <div class="mt-4">
            <x-button>{{ $buttonTitle }}</x-button>
        </div>
    </form>
</x-form-card>
