<x-guest-layout>
    <x-form-card :title="__('report.new') . ' - '. $book->title">
        <form class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white overflow-hidden sm:rounded-lg"
              action="{{route('report.send')}}" method="post">
            @csrf
            <x-auth-validation-errors class="mb-4" :errors="$errors"/>
            <div>
                <x-label :value="__('report.report_label')" for="content"></x-label>
                <x-textarea class="mt-4 min-w-full" name="content" id="content" maxlength="255">
                    {{old('content')}}
                </x-textarea>
            </div>
            <x-input type="hidden" value="{{$book->id}}" name="book_id"/>
            <x-button>{{__('report.send')}}</x-button>
        </form>
    </x-form-card>
</x-guest-layout>
