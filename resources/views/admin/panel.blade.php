<x-app-layout>
    <div class="p-3">
        <div>
            <h1 class="text-xl border-b-2 border-black">{{__('admin.genres').' '. __('admin.options')}}</h1>
            <x-link class="pl-3 inline-block" href="{{route('genre.create')}}">{{__('admin.new')}}</x-link>
        </div>
        <div class="mt-4">
            <h1 class="text-xl border-b-2 border-black">{{__('admin.books').' '. __('admin.options')}}</h1>
            <x-link class="pl-3 inline-block" href="{{route('admin.not_approved_books')}}">
                {{__('admin.not_approved')}} (<span class="text-md">{{$notApprovedCount}}</span>)
            </x-link>
            <x-link class="pl-3 inline-block" href="{{route('book.index')}}">
                {{__('admin.approved')}} (<span class="text-md">{{$approvedCount}}</span>)
            </x-link>
        </div>
    </div>
</x-app-layout>
