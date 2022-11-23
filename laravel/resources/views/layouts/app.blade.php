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

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bodyApp">
    <div id="app">
        <nav class="navbar navbar-expand-md  backgroundNav">
            <div class="containerNav">
                <a class="navbar-brand" href="{{ url('/dashboard') }}"><img class="logo"src="../images/logo_geomir.png"></img></a>

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
                                    <img id="burguer" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAABmJLR0QA/wD/AP+gvaeTAAAMk0lEQVR4nO2be3hV1ZXAf+vskxBMCEKxlI6iyNMJ5RVCpCAGFCxS5CFJKJCIAvGDRJkZ+aaOTAVstfqNn0ON
                                    4amgBGhIVEBpkciQqCAEiAEGPnkoPkAdi4DIM3DPXvPHuW0ZyE1ykxv9Y/L779xz1tprrbvP2eusvQ400kgjjTTy/xf5Pgb56XTt7FpSVOmh0EngRqAlEBe85AxwQuEzEQ4I7PYsJV/kycGGtq3BAtBuqnbD4T6rpAlcX0c1RwQKUZZ9Ml/2RNTAIBEO
                                    gErHqdyt8Bjw88tG+VqUEoRtatlvDZ8ELMeafcNZgNOtiHUdrnM82iHcAtyKkILS+jLlW6zlqcMLWQ+ikbI4YgHoMlUT1TIP6BP86YQqK3HIP7hAtoevUaVjFn2MkKHwK/xbBoVtRsn+cJF8EAm76x2AmyZqTGwTnkbJUTDAlwLPmvMs2pMvZwESpmmc
                                    XuI2hAEqdHWUjgo/5v8+A74GDgH7RHgHw+Z98+QMQLcMjfWu4UFVZgBtBDwgt7IJj36UK5X1sb9eAUiYpB0cQyFKT+CSCnOd88zxHVfp9iB3qeUBYDgQE6b6CyKsRXh5z0I2gGjCNI0zl5ilMB2IAj5QIW3vIvm4rj7UOQA9H9C+COvwp+YhC+m7X5IK
                                    gF6TdbQqjwPdg5dbYLsIm4ByTzhgXb6M9jgDcNEQ5wT4qePRBSFRYZBAEuAE5XcpzNn1kqwBSLxfe1mHVUAH4LhjGVa+VMq+twAkPqBDBF4HYhHWmgtklq2Q7xLv0/biMB9hcPDSowp50QHyty6TL8IZI3myXm+VDKtkC/xD8Oe3BLJ3LJHDyeM13otm
                                    OcJw4CwOo3a+KG+H60vYAeibqX2swyYgVuCVmJuYXDpbAskTdSywEIgHjiv8+9mzLNlXJBfDHeNyhj6kTU6cZhLwW/zZ9p0oU7a9IoWpqWo+j2MeShZwzhEGb10q74ejP6wA9J2gHcRQFjTkxfdfIQtE+2XqEyr8JnhZQUDJ2b5MjoejuyZSfqWtKqPJ
                                    E0gLWj7n/ZdlNqj0vY/FApOAbxxD8uYlcri2emsdgJSJGmMt7wM9gbWtz3NvUZF4AzI1F8gBAqo89F6+LAjPtfAYkKHZCHMBVyH3vWXycEqKuvZGXkcZDuyMbU7/9bVcHZyaLwleGOBpY+npWg7FemQWFYmXMl5/ayw5xnLe8RjV0M4DvJsvea4y2ljO
                                    u5aHBk3Q2aWlEog+R4axfGwsvSu/5cna6qvVDBgyThOtUAZYPJI3FkjFnRM0DWUV4Amkvr1CVtfVqbpwx3j9pcBqwAXGb1whK4N2bgMQJentlbKrJj21mAEqoswzFuNY5m4skIqh6dreeCw2FoxHzvftPMB/rZB1RvlnY8FY5g3J0HbFK6XcVXKNxTWW
                                    F2qjp8YADBvL3a7Sx1W+xGUOgAjzXCXehYINBQ0/7UOxYaW84Cqvukrz6EvkAUSfYZar/I+BfsPG6V016agxAEZ5zCi48Gxxvpy9J11Hu8oQA8ejL5ATCUfqg/WYZpSTjjJ0eLqOeOMNOW2U54yC8ZhZk3y1z4BR6dodyy7gxNkY2hbnc25UKhVAd4Sp
                                    qwuv/veffleHoSy8LHmJFEdVyXo0RdZfeWJkquYI5CpUrCkiMTWV2AB8DrTA4WerV8neUErd6kZ0AmSKgCori/Pl7JgxOhSlO3BUYElVMm0usACJuPPg1xQWAm2vPFF5hsWxsfwb0HPMGAYXFUnxvfdqgQhT8cgAfh1KabUBMJAmCijLAIxyf/BU3qpX
                                    q87wfnKpdt5EkvXrpXLsGM1T5Ul8G4td3+apQDrVBCDkLTDhHu2shv3AX1as5iepqcRGBzgGRBmXG5cVVZ3b71mtQ1VYRN2rQKE4gpDVfYS8VdXJzFRt6wX4BKiMDdBq0ZucHz+Kr4DW4tFx+RvyUVVyIWeAGAY6CqJsAtGml/Q2IAZlWyjnAbqNkvXA
                                    DeH5Vn+WFcnnmSN1J9Cn0tAfpNiovgOkicMgoMoAhFwFXI9uxoKon1i4yu3GggubGsSDCOAqJcaCY0kBMMo2Y0Es3ULKVKOsiwJi2Q/gWBLwj3dG2O6I4XjsDN7U/whgPA4ggNI5lEzIABhLOwSs9adOlNJJASM0eKm6rjiWA44/pzsDGDgULJ/eHEom
                                    dACUeBSaWk4GlbcCiPb4qjojHn9XhznCQm2IPEDIeqL/1XnA3zB8ZTwA31YVTrr+cXwokeoCEAfQPN4vW115HIobLrKAyDsP1eQBf6VJgNPBZa1ZVcdVUd0tUO1xSCvrVf+pP+HaXd1D8AzQ8tR3xAEnrjwOJde2kiylYfIA8UtfIYk+TzMnGhBOV3Vc
                                    FSED4CinBFoaoSVwwliOIbR0hDZUE4CEHygPAHBd2gQz12MAThQtjILAqVAyofMAy6fGguPRHsAoh4yFKC/0kvJD41q6BOsDBwGaBOgY9OGTUDIhA2CU/Ub9fADAVfYaBUfpHXnTI4OBRKPgWvYBONDZKBjLgVAyIQMQZdnt+v94XwDX8o5rwfUYFHnT
                                    I4Ox3OH6mWApQBT0df0ZsTuUTOi3QaHUWBAYqKjMgc1RygUg6ZkUvf7XpXK0KrHHtugwURYS4aVQlaMIWU+FyAOe7q9tPaUXcO7SGbYoKk8FU2JrQqfvIQPwmxI58MwAPaJww+/702d2qZQ9M0DXKqRjyQB+X5XcTRcaLg9QCZ0HiEOGURxR1s4sl3PR
                                    t2tfo1ynymcz3wm9d1htPUAshQ48YoQJQJlYXnb89+vs54fqcw+vv7r23rZee7V1Y3aKxjgBsgFEWQrgWjKDaXBBdbLVBiBaWGYtj6CM+48h+uiMYjb8Zz92AT0C/nbVvCtl2lWSZRsgDxA4Qog8oNlFskRoI1D+T1vY6PXTZlGWdAWMsrwGvdXzfF/d
                                    DPRT5ZHp2+S53L46Uv16/PGLF+kyo1y+qZNHEWL+z/XHl5T9QAsHhudslXW5t+q/qvAM8N7DW2VAdfI1VoUdy1NGwRVm5KVo3ENbZY1r2WCUHzWN8kvRPyTWMt8oLQz8KWerrHs+WeMd+Jfg8ve7muRrDEB2GeuDhYU25jyz/FGZZpRTRklbmKzZEfCj
                                    TixI1ulGGW2Ubx31S/TRMMcorY2yObtMimvSUWMABFEJkG0snrFMX5iovabtkMOuMiVYffnD4iQdHQmHwuHFJB1uLM8Gd6emTd0mny5K0qTgXmUgSmu3Z1GrzdEHy+UDV8l1lagmwqrlyRo/ebsUucocVzGusnxpkg6vn0u1Z0lvHWGUQldxo2DWlJ3y
                                    x6U99NoopcBV3CjL3EnbJWTyczm13h0+/S2PupZyx9LBXmJ5SYq69++U2cbfi2tqPF7P76UNvlOUn6jTXctrxhJjPJ6fuEOeKElR1zgsN5abjWXHNRdq3hH6K2E1SBQkanvPUgb8CHhpXAVTBNEVvXQ26j8fBF4NeGRn7pG/hOda9azsqq01innA6OA4
                                    s8ZVyBOKysoevIRwP3DM80jO3CMhX36uJOwWmYIemoRfGY4DlrW+lkkDSyVQ0ENTgcVAc+AkyuPxZ1l890f1a2NbmqIxMafIEmUOcC3wrQiT0yvktcJUNd4h5gtMwW+RuTOtQraGo79OTVKvd9XB1mE1EAu8aaPISCuXU4XdtJ0DecBQAIUvgbwoS/7I
                                    vXIknDEKE7StY8hAycavQaDKn1xDzqhd8mlhojaXi6wQYRhwRpRR9/63bAzXlzq3ya3ppslqWYfQCvjYUcaO2Cs7AdZ203usMhu/nQbAouwUYRNCOcqBi5Yv4G/1xbgmwvXq0MkqvQUGAYn8/RlVrsrs0XtlHcBrCZrkOBTgV3uP4fDLUbvr0o1az0bJ
                                    dT/Tm61lFdAbCAC5GmDWiANyWlFZ15XBqkwERgJNw1R/Dlijwssj9vrtb3/uoPGBJszB70lygR0Y0u8J456/knq3yv65gzax0TwpfvemC3yt8GyssGDgPr/V9c1EvcZU0t9abhdIADoBrbm6Vfagwj5RSu01bBleLucAShI07pxlKsIM/BbbgMDcM8LM
                                    tH31a8OLWLN0cYL2UOUFlH7Bn04Cf3Qg/84PKZMwO7wVlbe6cKsjZABjgRb+72zGIecX+2q3ztdExL8XeLuL3iXKTOC2ywY5BpRYZZsD+0U4bIVvThi/WtvSo5mjtFLlZoVbEG4VSFG47jLV74nwuzv215zehkODfTBRcot2Vf+dPA3/C5G68Jkoq9Ql
                                    f+CHobs86sP38slMSXvtYGCgCj1E6YRwE1d/MnMc5TMVDgpUeErpwI+r3tNvpJFGGmmkkcjwvyDt/fU5t+T7AAAAAElFTkSuQmCC">
                                </a>

                                <div class="dropdown-menu css-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        {{ __('fields.followers') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        {{ __('fields.profile') }}
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
        <main id="main">
            @yield('content')
        </main>
    </div>
</body>
</html>
