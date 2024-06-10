<div class="w-full flex justify-center items-center py-2 md:py-8">
    <div class="join">
        @if(!$game->isFirstGame())
            <a class="btn-error btn rounded-r-none rounded-l-3xl"
               id="previousGameBtn"
               href="{{route('bet.previousFromReference', compact('game'))}}"
            >
                <img width="20px" src="{{Vite::asset('resources/img/previous.svg')}}" alt="Backward arrow">
                <span class="hidden md:inline px-2">Precedente</span>
            </a>
        @endif
        <div class="dropdown text-sm">
            <div tabindex="0" role="button" class="btn btn-error mx-1 rounded-none">Lista Incontri</div>
            <ul tabindex="0" class="shadow menu z-[1] dropdown-content menu-horizontal top-12 left-0 bg-base-100 w-64 overflow-auto h-64 rounded-box">
                @foreach($games as $gameInBar)
                    <li @class([
                        'hidden' => !$gameInBar->started_at->isFuture() || !isset($gameInBar->home_team, $gameInBar->away_team),
                        'w-full'
                        ])>
                        <a @class([
                        'bg-accent text-accent-content' => $game->id === $gameInBar->id,
                        ]) href="{{route('prediction.index', ['game' => $gameInBar])}}">
                            {{$gameInBar->home_team->name}} - {{$gameInBar->away_team->name}}
                        </a>
                    </li>
                @endforeach
                <li>
                    <a class="font-bold">Incontri Disputati</a>
                    <ul>
                        @foreach($games as $gameInBar)
                            <li @class([
                                    'hidden' => !$gameInBar->started_at->isPast() || !isset($gameInBar->home_team, $gameInBar->away_team),
                                ])>
                                <a
                                        @class([
                                        'text-accent-content bg-accent' => $game->id === $gameInBar->id,
                                        ])
                                        href="{{route('prediction.index', ['game' => $gameInBar])}}">
                                    {{$gameInBar->home_team->name}} - {{$gameInBar->away_team->name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
        @if(!$game->isFinal())
            <a class="btn btn-error rounded-l-none rounded-r-3xl"
               id="nextGameBtn"
               href="{{route('bet.nextFromReference', compact('game'))}}"
            >
                <span class="hidden md:inline px-2">Prossimo</span>
                <img width="20px" src="{{Vite::asset('resources/img/next.svg')}}" alt="Foreward arrow">
            </a>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        function goTo() {
            window.location.assign('{{route('prediction.index', ['game' => $gameInBar])}}')
        }
    </script>
@endpush
