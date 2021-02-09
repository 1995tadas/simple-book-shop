<x-guest-layout>
    <x-genre-form :title="__('genre.new')" :action="route('genre.store')"
                 method="post" :buttonTitle="__('genre.create')">
    </x-genre-form>
</x-guest-layout>
