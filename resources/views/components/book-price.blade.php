@props(['price', 'discount'])

@if($price && $discount)
    <span class="line-through text-red-500">@currency($price)</span>
    | @currency($price - ($price * $discount / 100))
@elseif($price)
    @currency($price)
@else
    {{__('book.free')}}
@endif
