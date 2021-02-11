<x-app-layout>
    <div class="p-3 text-center">
        <ul>
            @forelse ($reports as $report)
                <li class="p-5 flex justify-between border-b-4 border-black">
                    <span class="text-xs">
                          <x-link href="{{route('report.show', ['report' => $report->id])}}">
                            {{__('report.open')}}
                          </x-link>
                        @if(!$report->seen)
                            <span class="block text-red-500">{{__('report.fresh')}}</span>
                        @endif
                    </span>
                    <span class="text-xs">{{__('report.sender') .': '.$report->user->name }}</span>
                    <span class="text-xs">{{__('report.book_title') .': '}}
                        <x-link href="{{route('book.show', ['book' => $report->book->slug])}}">
                            {{$report->book->title}}
                        </x-link>
                    </span>
                    <span class="text-xs">{{__('report.date') .': '.$report->created_at }}</span>
                </li>
                {{ $reports->links() }}
            @empty
                <li>{{__('report.empty')}}</li>
            @endforelse
        </ul>
    </div>
</x-app-layout>
