<header
    class="bg-white py-4 px-1 sm:px-6 lg:px-8 shadow flex items-center justify-center md:justify-between flex-wrap">
    <form action="{{route('search')}}" method="post">
        @csrf
        <x-input id="search" class="block p-1 mb-1 sm:mb-0" type="text"
                 name="search" :value="Session::has('search') ? Session::get('search'):''"
                 maxlength="255" required/>
    </form>
    <div class="flex whitespace-nowrap justify-center md:justify-between px-5 flex-wrap">
        @guest()
            <a class="bg-white hover:opacity-50 py-1 px-5 border-2 border-black text-black rounded"
               href="{{ route('login') }}">
                <button class="focus:outline-none" type="button">{{__('additional.sign_in')}}
                </button>
            </a>
            <a class="bg-black hover:opacity-50 py-1 px-5 border-2 border-black text-white rounded ml-2"
               href="{{ route('register') }}">
                <button class="focus:outline-none" type="button">
                    {{__('additional.sign_up')}}
                </button>
            </a>
        @else
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.panel') }}">
                    <x-header-button class="bg-white text-black ml-2">{{__('additional.panel')}}</x-header-button>
                </a>
            @endif
            <a href="{{ route('book.create') }}">
                <x-header-button class="bg-white text-black ml-2">{{__('book.new')}}</x-header-button>
            </a>
            <form action="{{ route('logout') }}" method="post">
                @csrf()
                <x-header-button class="bg-black text-white ml-2">{{__('additional.log_out')}}</x-header-button>
            </form>
        @endguest
    </div>
</header>
