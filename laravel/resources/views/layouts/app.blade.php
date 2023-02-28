@include('flash')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Geo-Mir</title>
    <link rel='icon' href="../../images/"></link>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles and scripts -->
   @env(['local','development'])
       @vite(['resources/sass/app.scss', 'resources/js/bootstrap.js'])  
   @endenv
   @env(['production'])
       @php
           $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
       @endphp
       <script type="module" src="/build/{{ $manifest['resources/js/app.js']['file'] }}"></script>
       <link rel="stylesheet" href="/build/{{ $manifest['resources/sass/app.scss']['file'] }}">
   @endenv

</head>
<body class="bodyApp">
    <div id="app">
        <nav class="navbar navbar-expand-md  backgroundNav">
            <div class="containerNav">
                <a class="navbar-brand" href="{{ url('/dashboard') }}"><img class="logo" alt="logoGeo-mir" src="../images/logo_geomir.png"></img></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @guest
                    @if (Route::has('register'))
                    @endif
                    @else
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <div id="botoneraContainer">
                                <ul class="botonera" data-animation="center">
                                    <li class="ms-auto botons">
                                        <a class="navLink" href="{{ url('/files') }}">{{ __('fields.files') }}</a>
                                    </li>
                                    <li class=" ms-auto botons">
                                        <a class="navLink" href="{{ url('/posts') }}">{{ __('fields.posts') }}</a>
                                    </li>
                                    <li class="ms-auto botons">
                                        <a class="navLink" href="{{ url('/places') }}">{{ __('fields.places') }}</a>
                                    </li>
                                </ul>
                            </div>
                @endguest
                    <!-- Right Side Of Navbar -->
                    
                    @include('partials.language-switcher')
                    <ul class="navbar-nav ms-auto"  data-animation="center">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="navLink fontRegister" href="{{ route('register') }}">{{ __('fields.Register') }}</a>
                                </li>
                            @endif
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="navLink fontRegister" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="https://icons8.com/icon/52946/menú-xbox" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img id="burguer" alt="menú desplegable" src ="../../images/menu.png" >
                                </a>

                                <div class="dropdown-menu css-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        {{ __('fields.followers') }}
                                    </a>
                                    <a class="dropdown-item">
                                        {{ __('fields.profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ url('/about-us') }}">
                                        {{ __('About us') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ url('/contact-page') }}"  accesskey="c">
                                        {{ __('Página de contacto') }}
                                    </a>
                                    <form id="seguidors-form" action="{{ route('dashboard') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    <form id="perfil-form" action="{{ route('dashboard') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
