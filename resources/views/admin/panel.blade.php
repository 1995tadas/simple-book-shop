<x-app-layout>
    <div class="p-3">
        <div>
            <h1 class="text-xl border-b-2 border-black">{{ __('admin.genres').' '. __('admin.options') }}</h1>
            <x-link class="pl-3 inline-block" href="{{ route('admin.genre.create')}}">{{__('admin.new') }}</x-link>
        </div>
        <div class="mt-4">
            <h1 class="text-xl border-b-2 border-black">{{ __('admin.books').' '. __('admin.options') }}</h1>
            <x-link class="pl-3 inline-block" href="{{ route('admin.not_approved_books') }}">
                {{ __('admin.not_approved') }} (<span class="text-md">{{ $notApprovedBooksCount }}</span>)
            </x-link>
            <x-link class="pl-3 inline-block" href="{{ route('book.index') }}">
                {{ __('admin.approved') }} (<span class="text-md">{{ $approvedBooksCount }}</span>)
            </x-link>
        </div>
        <div class="mt-4">
            <h1 class="text-xl border-b-2 border-black">{{ __('admin.user').' '. __('admin.options') }}</h1>
            <x-change-password :admin-panel="true"></x-change-password>
        </div>
    </div>
</x-app-layout>
