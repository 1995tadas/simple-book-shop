<x-app-layout>
    <div class="p-3">
        <div class="flex-col md:flex-row flex md:h-2/4">
            <div class="flex justify-content-center md:mr-5">
                <img class="h-96" alt="{{ $book->title.' cover'}}"
                     title="{{$book->title}}"
                     src="{{asset('storage/' . $book->cover)}}">
            </div>
            <div class="flex-1 text-left">
                <h1 class="text-3xl border-b-4 border-dark">{{$book->title}}</h1>
                <div class="flex justify-content-between">
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
                    <book-rating store-route="{{  route('rating.store', ['book' => $book->slug]) }}"></book-rating>
                </div>
                <p class="h-3/4 text-2xl flex align-items-center mt-1 md:mt-0">
                    {{$book->description}}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
