<x-app-layout>
    <div class="p-3">
        <div class="flex flex-col md:flex-row md:h-2/4">
            <div class="flex justify-center md:mr-5">
                <img class="h-96" alt="{{$book->title.' cover'}}"
                     title="{{$book->title}}"
                     src="{{asset('storage/' . $book->cover)}}">
            </div>
            <div class="flex-1 text-left">
                <h1 class="text-3xl border-b-4 border-black">{{$book->title}}</h1>
                <div class="flex flex-col md:flex-row justify-between">
                    <div class="mt-2">
                        <div>
                            <h2 class="text-xl inline">{{__('book.author')}}</h2>
                            <ul class="ml-2 inline font-bold">
                                @foreach($authors as $author)
                                    <li class="inline m-1 bg-blue-100 p-1 rounded">{{$author->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-3">
                            <h2 class="text-xl inline">{{__('book.genres')}}</h2>
                            <ul class="ml-2 inline font-bold">
                                @foreach($genres as $genre)
                                    <li class="inline m-1 bg-blue-100 p-1 rounded">{{$genre->title}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @auth
                        <div>
                            <book-rating store-route="{{ route('rating.store', ['book' => $book->slug]) }}"
                                         destroy-route="{{ route('rating.destroy', ['book' => $book->slug]) }}"
                                         :ratings="{{ $ratings }}"
                                         @if($user_rating)
                                         :user-rating="{{ $user_rating }}"
                                @endif
                            ></book-rating>
                            <div class="text-center">
                                @if(!$book->approved)
                                    <div class="text-green-400 hover:text-green-200">
                                        <form action="{{route('admin.approve_book', ['book' => $book->slug])}}"
                                              method="post">
                                            @csrf
                                            @method('put')
                                            <button class="focus:outline-none">
                                                <i class="fas fa-check-square"></i>
                                                <span>{{ __('book.approve') }}</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                                @auth()
                                    @if(auth()->user()->is_admin || auth()->user()->id === $book->user_id)
                                        <div class="text-red-400 hover:text-red-200">
                                            <form action="{{route('book.destroy', ['book' => $book->slug])}}"
                                                  method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="focus:outline-none">
                                                    <i class="fas fa-ban"></i>
                                                    <span>{{ __('book.delete') }}</span>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endauth
                </div>
                <p class="h-3/4 text-2xl flex items-center text-justify md:text-left mt-1 md:mt-0">
                    {{$book->description}}
                </p>
            </div>
        </div>
        <div class="my-2">
            <div class="flex justify-between py-3 w-100">
                <div class="w-60 hidden md:block md:invisible"><span class="inline">|</span></div>
                <div class="flex-grow">
                    <h1 class="w-100 text-3xl border-b-4 border-black">{{__('book.reviews')}}</h1>
                </div>
            </div>
            @foreach($reviews as $review)
                <div class="flex justify-between py-3 w-100 break-all">
                    <div class="w-100 md:w-60 text-right">
                        <span class="text-xs inline m-1 bg-blue-100 p-1 rounded">{{$review->created_at}}</span>
                        <span class="inline m-1 bg-blue-100 p-1 rounded">{{$review->users->name}}</span>
                    </div>
                    <span class="flex-1">{{$review->content}}</span>
                </div>
            @endforeach
            <div class="flex justify-start md:justify-end">
                {{$reviews->links()}}
            </div>
            @auth
                <div class="flex justify-between py-3 w-100">
                    <div class="w-60 hidden md:block md:invisible"><span class="inline">|</span></div>
                    <div class="flex-grow">
                        <review
                            :translation="{{ json_encode(trans('review')) }}"
                            store-route="{{ route('review.store', ['book' => $book->slug]) }}"
                        >
                        </review>
                    </div>
                </div>
            @else
                <div class="text-right mt-1">
                    {{__('review.not_logged_first_part')}}
                    <x-link href="{{route('login')}}">
                        {{ __('review.not_logged_second_part') }}
                    </x-link>
                    {{ __('review.not_logged_third_part') }}
                    <x-link href="{{route('register')}}">
                        {{ __('review.not_logged_fourth_part') }}
                    </x-link>
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>
