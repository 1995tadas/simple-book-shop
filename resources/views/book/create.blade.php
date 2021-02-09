<x-guest-layout>
    <x-book-form :title="__('book.new')" :action="route('book.store')"
                 method="post" :buttonTitle="__('book.create')" :genres="$genres">
    </x-book-form>
</x-guest-layout>
