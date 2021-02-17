@component('mail::message')
# {{$data['content']}}

{{$data['from']}}

[{{$data['bookTitle']}}]({{$data['bookLink']}})
@endcomponent
