<x-app-layout>
    <div class="p-3 text-center">
        @if(session()->has('success'))
            <x-success class="mb-2">
                {{ session()->get('success') }}
            </x-success>
        @endif
        @if(session()->has('error'))
            <x-error class="mb-2">
                {{ session()->get('error') }}
            </x-error>
        @endif
        <h1 class="text-3xl mb-3 capitalize bold">
            @if(isset($title))
                {{$title}}
            @elseif(request()->has('search'))
                {{ $books->total() }}
            @endif
            {{ __('book.books') }}
        </h1>
        @if($books->isEmpty())
            <div class="text-xl pt-3">{{ __('book.empty') }}</div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 box-border">
                @foreach($books as $book)
                    <div class="text-left bg-white p-4">
                        <a href="{{ route('book.show', $book) }}" class="relative block">
                            {{--  New book  --}}
                            @if(($book->isNew))
                                <span class="absolute top-2 right-2 text-red-600 rounded font-bold bg-white px-1">
                                    {{ __('book.recent') }}
                                </span>
                            @endif

                            {{--  Discount  --}}
                            @if($book->discount)
                                <div class="absolute inset-x-0 bottom-0 h-16 text-center">
                                    <span class="text-red-600 rounded text-xl font-bold bg-white px-1">
                                        <i class="fas fa-tags"></i> {{ $book->discount.' %' }}
                                    </span>
                                </div>
                            @endif

                            {{--  Cover  --}}
                            @if($book->cover)
                                <img class="hover:opacity-50" alt="{{ $book->title . __('book.cover') }}"
                                     title="{{ __('book.open') . ' ' . $book->title }}"
                                     src="{{ asset('storage/' . $book->cover) }}">
                            @else
                                <img class="hover:opacity-50" alt="{{ $book->title . __('book.placeholder') }}"
                                     title="{{ __('book.open') . ' ' . $book->title }}"
                                     src="{{ asset('images/book-placeholder.jpg') }}">
                            @endif
                        </a>
                        <h2 class="text-sm">{{ __('book.title') }}</h2>
                        <h3 class="text-xs pl-3 py-1 bg-gray-200 rounded">{{ $book->title }}</h3>
                        <h2 class="text-sm">{{ __('book.authors') }}</h2>
                        <ul class="text-xs pl-3 py-1 bg-gray-200 rounded">
                            @foreach($book->authors as $author)
                                <li>{{ $author->name }}</li>
                            @endforeach
                        </ul>
                        <h2 class="text-sm">{{ __('book.price') }}</h2>
                        <h3 class="text-xs pl-3 py-1 bg-gray-200 rounded">
                            @if($book->price == 0)
                                {{ __('book.free') }}
                            @else
                                {{ $book->price.' €' }}
                            @endif
                        </h3>
                    </div>
                @endforeach
            </div>
            <div class="pt-3">
                {{ $books->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
