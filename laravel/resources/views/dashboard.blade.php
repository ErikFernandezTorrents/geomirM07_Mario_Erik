<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
    @section('content')
    <div ><img id="mapa" src="../../images/mapa.png"></div>
    <footer id="footer">
        <li class="nav-item">
            <a class="navLink fontRegister" href="{{ route('about_us') }}">{{ __('About us') }}</a>
        </li>
    </footer>
    @endsection
</x-app-layout>
