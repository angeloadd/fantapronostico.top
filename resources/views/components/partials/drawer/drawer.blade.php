<div class="drawer lg:drawer-open w-full">
    <input class="drawer-toggle" type="checkbox" id="sidebarBtn"/>
    <div class="drawer-content h-screen w-full flex justify-center items-center overflow-y-auto">
        <label for="sidebarBtn" aria-label="close sidebar" class="lg:hidden btn btn-neutral rounded-tl-lg rounded-bl-lg rounded-none fixed top-2 right-0 w-12 z-10 opacity-50">
            <img src="{{Vite::asset('resources/img/sidebar/bars.svg')}}" alt="sidebar burger button">
        </label>
        {{$slot}}
    </div>
    <div class="drawer-side text-base-100">
        <label for="sidebarBtn" aria-label="close sidebar" class="drawer-overlay"></label>
        <div class="min-h-screen bg-accent flex flex-col items-center justify-between">
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
                    <div class="dropdown dropdown-top dropdown-start flex">
                        <div tabindex="0" role="button" class="flex items-center w-full">
                            <img src="{{Vite::asset('resources/img/sidebar/profile.svg')}}"
                                 alt="grind"
                                 width="32"
                                 class="rounded-circle me-2"">
                            <p class="w-fit">
                                <strong class="text-2xl">{{Auth::user()->name ?? 'Accedi'}}</strong>
                            </p>
                        </div>
                        <ul tabindex="0" class="dropdown-content z-[1] text-lg rounded-lg bg-accent shadow-lg" aria-labelledby="dropdownUser1">
                            @guest
                                <li>
                                    <a href="{{ route('login') }}">Accedi</a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}">Iscriviti</a>
                                </li>
                            @else
                                @if(auth()->user()->admin)
                                    <li>
                                        <a href="/admin">
                                            PannelloMod
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <button type="button" onclick="logOutModal.showModal()">
                                        Logout
                                    </button>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<x-auth::logout/>
