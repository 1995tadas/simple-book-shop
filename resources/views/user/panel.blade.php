<x-app-layout>
    <div class="p-3">
        <div>
            <h1 class="text-xl border-b-2 border-black">{{__('user.my_books')}}</h1>
            <x-link class="pl-3 inline-block" href="{{route('user.approved_books')}}">
                {{__('user.approved')}} (<span class="text-md">{{$approvedBooksCount}}</span>)
            </x-link>
            <x-link class="pl-3 inline-block" href="{{route('user.not_approved_books')}}">
                {{__('user.not_approved')}} (<span class="text-md">{{$notApprovedBooksCount}}</span>)
            </x-link>
        </div>
        <div class="mt-4">
            <h1 class="text-xl border-b-2 border-black">{{__('user.my_account')}}</h1>
            <x-change-password></x-change-password>
        </div>
    </div>
</x-app-layout>