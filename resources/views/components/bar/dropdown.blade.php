<div class="dropdown text-sm">
    <div tabindex="0" role="button" class="btn {{$btnClasses}} flex-nowrap">
        <span class="text-sm">
            Lista Incontri
        </span>
        <svg
            class="size-4"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </div>
    <ul tabindex="0" class="shadow menu z-[1] dropdown-content menu-horizontal @if($right ?? false) right-0 bottom-12 @else left-0 top-12 @endif bg-base-100 overflow-auto size-64 rounded-box">
        <x-bar.games :$games :$game hiddenOn="isPast"/>
        <li class="w-full">
            <div class="font-bold">Incontri Disputati</div>
            <ul>
                <x-bar.games :$games :$game hiddenOn="isFuture" />
            </ul>
        </li>
    </ul>
</div>
