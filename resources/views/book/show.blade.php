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
        <book-show
                    :translation="{{ json_encode(trans('book')) }}"
                    :translation-review="{{ json_encode(trans('review')) }}"

                    book-load-route="{{ route('api.book.load', $book)}}"
                    user-route="{{ route('api.user') }}"

                    @auth()
                        book-destroy-route="{{ route('user.book.destroy', $book) }}"
                        book-report-route="{{ route('user.report.create', $book) }}"
                        book-edit-route="{{ route('user.book.edit', $book) }}"
                        book-approve-route="{{ route('api.admin.approve_book', $book) }}"
                        rating-store-route="{{ route('api.user.rating.store', $book) }}"
                        rating-destroy-route="{{ route('api.user.rating.destroy', $book) }}"
                        review-store-route="{{ route('api.user.review.store', $book) }}"
                    @else
                        register-route="{{ route('login') }}"
                        login-route="{{ route('register') }}"
                    @endauth>
            @csrf
        </book-show>
    </div>
</x-app-layout>
