<x-guest-layout>
    <x-book-form :title="ucfirst(__('book.edit'))" :action="route('user.book.update', $book)"
                 method="put" :buttonTitle="__('book.save')" :genres="$genres"
                 :fieldTitle="$book->title" :fieldAuthors="$authors"
                 :fieldPrice="$book->price" :fieldDiscount="$book->discount"
                 :fieldDescription="$book->description" :fieldGenres="$genresOld">
    </x-book-form>
</x-guest-layout>
