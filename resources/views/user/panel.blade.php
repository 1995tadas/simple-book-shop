<x-app-layout>
    <div class="p-3">
        <div>
            <h1 class="text-xl border-b-2 border-black">{{__('user.my_books')}}</h1>
            <x-link class="pl-3 inline-block" href="{{route('user.approved_books')}}">
                {{__('user.approved')}}
            </x-link>
            <x-link class="pl-3 inline-block" href="{{route('user.not_approved_books')}}">
                {{__('user.not_approved')}}
            </x-link>
        </div>
    </div>
</x-app-layout>
