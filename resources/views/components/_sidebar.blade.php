<aside
    class="flex flex-col p-3 text-base-100 bg-neutral sidebar-custom"
>
    <div class="w-full flex">
        <button class="ms-auto lg:hidden btn" type="button" id="asideCloseBtn"
        >
            <img width="32px"
                 src="{{Vite::asset('resources/img/sidebar/close.svg')}}"
                 alt="dashboard"
            >
        </button>
    </div>
    <a href="/" class="text-2xl flex items-center mb-3 lg:me-4 text-base-100">
        <img
            class="object-cover rounded-lg me-3"
            width="40"
            height="40"
            src="{{Vite::asset('resources/img/worldCup2022.svg')}}" alt=""
        >
        <span class="lg:me-4">{{config('app.name')}}</span>
    </a>
    <hr>
    <ul class="flex-col text-xl mb-auto mt-3">
        <li class="my-2">
            <a href="/" class= text-base-100 @if(Route::currentRouteName() === '/') active @endif"
               aria-current="page">
                <img class="me-2" width="20px" src="{{Vite::asset('resources/img/sidebar/home.svg')}}"
                     alt="dashboard">
                Home
            </a>
        </li>
        <li class="my-2">
            <a href="{{route('bet.nextGame')}}"
               class="text-base-100 @if(Route::currentRouteName() === 'bet.create') active @endif">
                <img class="me-2" width="20px" src="{{Vite::asset('resources/img/sidebar/bet.svg')}}"
                     alt="dashboard">
                Pronostico
            </a>
        </li>
        <li class="my-2">
            <a title="Vincente e Capocannoniere" href="{{route('champion.create')}}"
               class="text-base-100 @if(Route::currentRouteName() === 'champion.index') active @endif">
                <img class="me-2" width="20px" src="{{Vite::asset('resources/img/sidebar/winner.svg')}}"
                     alt="dashboard">
                Vincente
            </a>
        </li>
        <li class="my-2">
            <a href="{{route('standing')}}"
               class="text-base-100 @if(Route::currentRouteName() === 'standing') active @endif">
                <img class="me-2" width="20px" src="{{Vite::asset('resources/img/sidebar/rank.svg')}}"
                     alt="rank">
                Classifica
            </a>
        </li>
        <li class="my-2">
            <a href="{{route('albo')}}"
               class="text-base-100 @if(Route::currentRouteName() === 'albo') active @endif">
                <img class="me-2" width="20px" src="{{Vite::asset('resources/img/sidebar/albo.svg')}}"
                     alt="rank">
                Albo d'oro
            </a>
        </li>
    </ul>
    <div class="dropdown">
        <a href="#" class="flex items-center text-white text-decoration-none dropdown-toggle"
           id="dropdownUser1"
           data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{Vite::asset('resources/img/sidebar/profile.svg')}}"
                 alt="grind"
                 width="32"
                 height="32"
                 class="rounded-circle me-2">
            <strong>{{Auth::user()->full_name ?? 'Guest'}}</strong>
        </a>
        @guest
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow-lg" aria-labelledby="dropdownUser1">
                <li>
                    <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                </li>

            </ul>
        @else
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow-lg" aria-labelledby="dropdownUser1">
                @if(Auth::user()->games_mod || Auth::user()->users_mod)
                    <li>
                        <a class="dropdown-item" href="{{route('mod.index')}}">
                            PannelloMod
                        </a>
                    </li>
                @endif
                <li>
                    <a class="dropdown-item" href="{{route('statistics', ['user' => auth()->user()])}}">
                        Statistiche
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{route('password.firstSet')}}">
                        Cambia Password
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <button type="button"
                            class="dropdown-item text-base-100"
                            data-bs-toggle="modal"
                            data-bs-target="#logOutModal">
                        Logout
                    </button>
                </li>
            </ul>
        @endguest
    </div>
</aside>

<x-_logout/>
