<div class="w-full flex justify-center items-center py-2 md:py-8">
    <div class="join">
        <x-bar.link
                link="{{route('prediction.previous-from-ref', compact('game'))}}"
                img="previous.svg"
                alt="Backward Arrow"
                side="left"
                condition="{{!$game->isFirstGame()}}"
        />
        <div class="dropdown text-sm">
            <div tabindex="0" role="button" class="btn btn-primary mx-1 rounded-none text-base-100">Lista Incontri</div>
            <ul tabindex="0" class="shadow menu z-[1] dropdown-content menu-horizontal top-12 left-0 bg-base-100 w-64 overflow-auto h-64 rounded-box">
                <x-bar.games :$games :$game :hiddenOn="fn($gameFromList) => !$gameFromList->started_at->isFuture()"/>
                <li class="w-full">
                    <div class="font-bold">Incontri Disputati</div>
                    <ul>
                        <x-bar.games :$games :$game :hiddenOn="fn($gameFromList) => !$gameFromList->started_at->isPast()" />
                    </ul>
                </li>
            </ul>
        </div>
        <x-bar.link
                link="{{route('prediction.next-from-ref', compact('game'))}}"
                img="next.svg"
                alt="Forward Arrow"
                side="right"
                condition="{{!$game->isFinal()}}"
        />
    </div>
</div>
