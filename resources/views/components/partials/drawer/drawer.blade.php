<div class="drawer lg:drawer-open w-full">
    <input class="drawer-toggle" type="checkbox" id="sidebarBtn"/>
    <div class="drawer-content">
        <label for="sidebarBtn" aria-label="close sidebar" class="lg:hidden btn btn-neutral rounded-none btn-gear-custom">
            <img src="{{Vite::asset('resources/img/sidebar/bars.svg')}}" alt="sidebar burger button">
        </label>
        {{$slot}}
    </div>
    <div class="drawer-side text-base-100">
        <label for="sidebarBtn" aria-label="close sidebar" class="drawer-overlay"></label>
        <div class="min-h-screen bg-neutral flex flex-col items-center justify-between">
            <ul class="menu text-lg space-y-3">
                <li class="w-72 mb-9">
                    <x-partials.logo.large primary="#e5e7eb"/>
                </li>
                <x-partials.drawer.item routeName="home" svg="home" text="Home"/>
                <x-partials.drawer.item routeName="bet.nextGame" active="bet.create" svg="bet" text="Pronostico"/>
                <x-partials.drawer.item routeName="champion.create" active="champion.index" svg="winner" text="Vincente"/>
                <x-partials.drawer.item routeName="standing" svg="rank" text="Classifica"/>
                <x-partials.drawer.item routeName="albo" svg="albo" text="Albo d'oro"/>
            </ul>
            <ul class="menu w-full">
                <li class="w-full">
                    <div class="bg-base-100/70 p-[0.025rem] -mt-3 mx-3"></div>
                </li>
                <li>
                    <details>
                        <summary class="flex items-center">
                            <img src="{{Vite::asset('resources/img/sidebar/profile.svg')}}"
                                 alt="grind"
                                 width="32"
                                 class="rounded-circle">
                            <strong class="text-2xl">{{Auth::user()->name ?? 'Accedi'}}</strong>
                        </summary>
                        <ul class="text-lg rounded-lg bg-neutral shadow-lg" aria-labelledby="dropdownUser1">
                            @guest
                                <li>
                                    <a href="{{ route('login') }}">Accedi</a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}">Iscriviti</a>
                                </li>
                            @else
                                @if(Auth::user()->games_mod || Auth::user()->users_mod)
                                    <li>
                                        <a href="{{route('mod.index')}}">
                                            PannelloMod
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{route('statistics', ['user' => auth()->user()])}}">
                                        Statistiche
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('password.firstSet')}}">
                                        Cambia Password
                                    </a>
                                </li>
                                <li>
                                    <button type="button" onclick="logOutModal.showModal()">
                                        Logout
                                    </button>
                                </li>
                            @endguest
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
    </div>
</div>
<x-_logout/>
