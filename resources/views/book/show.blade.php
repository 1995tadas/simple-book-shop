<x-app-layout>
    <div class="p-3">
        @if(session()->has('success'))
            <x-success class="mb-5">
                {{ session()->get('success') }}
            </x-success>
        @endif
        @if(session()->has('error'))
            <x-error class="mb-5">
                {{ session()->get('error') }}
            </x-error>
        @endif
        <div class="flex flex-col md:flex-row md:h-2/4">
            <div class="flex justify-center md:mr-5">
                <x-book-cover
                    :cover="$book->cover" :title="$book->title"
                    :new="$book->isNew" :discount="$book->discount">
                </x-book-cover>
            </div>
            <div class="flex-1 text-left">
                <h1 class="text-3xl border-b-4 border-black">{{ $book->title }}</h1>
                <div class="flex flex-col md:flex-row justify-between">
                    <div class="mt-2">
                        <div>
                            <h2 class="text-xl inline">{{ __('book.authors') }}</h2>
                            <ul class="ml-2 inline font-bold leading-9">
                                @foreach($authors as $author)
                                    <li class="inline m-1 bg-blue-100 p-1 rounded">{{ $author->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-3">
                            <h2 class="text-xl inline">{{ __('book.genres') }}</h2>
                            <ul class="ml-2 inline font-bold leading-9">
                                @foreach($genres as $genre)
                                    <li class="inline m-1 bg-blue-100 p-1 rounded">{{ $genre->title }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="mt-3">
                            <h2 class="text-xl inline">{{ __('book.price') }}</h2>
                            <span class="m-1 bg-blue-100 p-1 rounded">
                                <x-book-price :price="$book->price" :discount="$book->discount"></x-book-price>
                            </span>
                        </div>
                    </div>
                    <div>
                        <book-rating
                            :average="{{ $averageRatings }}"
                            :raters-count="{{ $ratersCount }}"
                            @auth()
                            store-route="{{ route('user.rating.store', $book) }}"
                            destroy-route="{{ route('user.rating.destroy', $book) }}"
                            @endauth
                            @if($userRating)
                            :user-rating="{{ $userRating }}"
                            @endif>
                        </book-rating>
                        @auth
                            <div class="text-center">
                                @if(auth()->user()->is_admin && $book->approved_at === null)
                                    <div class="text-green-400 hover:text-green-200">
                                        <form action="{{ route('admin.approve_book', $book) }}"
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
                                @if(auth()->user()->is_admin || auth()->id() === $book->user_id)
                                    <div class="text-red-400 hover:text-red-200">
                                        <form action="{{ route('user.book.destroy', $book) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="focus:outline-none"
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-ban"></i>
                                                <span>{{ __('book.delete') }}</span>
                                            </button>
                                        </form>
                                    </div>
                                    <x-link class="block mb-0 mr-0"
                                            href="{{ route('user.book.edit', $book) }}">
                                        <i class="far fa-edit"></i> {{ __('book.edit') }}
                                    </x-link>
                                @endif
                                <x-link href="{{ route('user.report.create', $book) }}">
                                    <i class="fas fa-bug"></i> {{ __('book.report') }}
                                </x-link>
                            </div>
                        @endauth
                    </div>
                </div>
                <p class="h-3/4 text-2xl md:text-left mt-1 md:mt-0">
                    {{ $book->description }}
                </p>
            </div>
        </div>
        <div id="reviews" class="my-2">
            <div class="flex justify-between py-3 w-100">
                <div class="w-60 hidden md:block md:invisible"><span class="inline">|</span></div>
                <div class="flex-grow">
                    <h1 class="w-100 text-3xl border-b-4 border-black">{{ __('book.reviews') }}</h1>
                </div>
            </div>
            @foreach($reviews as $review)
                <div class="flex justify-between flex-col md:flex-row py-3 w-100">
                    <div class="w-100 md:w-60 flex-left md:text-right">
                        <div class="text-xs m-0 md:m-1 mb-3">
                            <span class="bg-blue-100 p-1 rounded">{{ $review->created_at }}</span>
                        </div>
                        <span class="m-0 md:m-1 bg-blue-100 p-1 rounded">{{ $review->users->name }}</span>
                    </div>
                    <span class="flex-1 mt-1 md:mt-0 break-all">{{ $review->content }}</span>
                </div>
            @endforeach
            <div class="flex justify-start md:justify-end">
                {{ $reviews->links() }}
            </div>
            @auth
                <div class="flex justify-between py-3 w-100">
                    <div class="w-60 hidden md:block md:invisible"><span class="inline">|</span></div>
                    <div class="flex-grow">
                        <review
                            :translation="{{ json_encode(trans('review')) }}"
                            store-route="{{ route('user.review.store', $book) }}"
                            :reviews-per-page="{{ $reviews->perPage() }}"
                            :page="{{ $reviews->currentPage() }}">
                        </review>
                    </div>
                </div>
            @else
                <div class="text-right mt-1">
                    {{ __('review.not_logged_first_part') }}
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
