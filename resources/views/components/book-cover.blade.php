@props(['cover','title', 'new', 'discount', 'link' => false])

{{--  New book  --}}
<div class="relative block">
    @if(($new))
        <span class="absolute top-2 right-2 text-red-600 rounded font-bold bg-white px-1">
        {{ __('book.recent') }}
    </span>
    @endif

    {{--  Discount  --}}
    @if($discount)
        <div class="absolute inset-x-0 bottom-0 h-16 text-center">
        <span class="text-red-600 rounded text-xl font-bold bg-white px-1">
            <i class="fas fa-tags"></i> {{ $discount.' %' }}
        </span>
        </div>
    @endif

    {{--  Cover  --}}
    <img
        alt="{{ $title . __('book.cover') }}"
        title="{{ $title }}"
        src="{{ asset($cover) }}"
        @if($link)
            class="hover:opacity-50"
        @else
            class="h-96"
        @endif>
</div>
