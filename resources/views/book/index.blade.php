<x-app-layout>
    <div class="p-3 text-center">
        @if($books->isEmpty())
            <div class="text-xl pt-3">{{__('book.empty')}}</div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-20 box-border">
                @foreach($books as $book)
                    <div class="text-left">
                        <a href="{{route('book.show', ['book' => $book->slug])}}" class="relative block">
                            @if((\Carbon\Carbon::parse($book->created_at))->gt(\Carbon\Carbon::now()->subWeek()))
                                <span class="absolute top-2 right-2 text-red-600 rounded font-bold bg-white px-1">
                                    {{__('book.recent')}}
                                </span>
                            @endif
                            @if($book->discount)
                                <div class="absolute inset-x-0 bottom-0 h-16 text-center">
                                <span class="text-red-600 rounded text-2xl font-bold bg-white px-1">
                                    <i class="fas fa-tags"></i> {{$book->discount.' %'}}
                                </span>
                                </div>
                            @endif
                            <img class="hover:opacity-50" alt="{{$book->title.' cover'}}"
                                 title="{{__('book.open').' '.$book->title}}"
                                 src="{{asset('storage/' . $book->cover)}}">
                        </a>
                        <h2 class="text-xl">{{__('book.title')}}</h2>
                        <h3 class="pl-3 py-1 bg-gray-200 rounded">{{$book->title}}</h3>
                        <h2 class="text-xl">{{__('book.author')}}</h2>
                        <ul class="pl-3 py-1 bg-gray-200 rounded">
                            @foreach($book->authors as $author)
                                <li>{{$author->name}}</li>
                            @endforeach
                        </ul>
                        <h2 class="text-xl">{{__('book.price')}}</h2>
                        <h3 class="pl-3 py-1 bg-gray-200 rounded">
                            @if($book->price == 0)
                                {{__('book.free')}}
                            @else
                                {{$book->price.' €'}}
                            @endif
                        </h3>
                    </div>
                @endforeach
            </div>
            <div class="pt-3">
                {{ $books->links() }}
            </div>
    </div>
    @endif
</x-app-layout>
