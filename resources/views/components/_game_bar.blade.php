<div class="w-full flex justify-center items-center py-2">
    <div class="join">
        @if(!$game->isFirstGame())
            <a class="btn-error btn"
               id="previousGameBtn"
               href="{{route('bet.previousFromReference', compact('game'))}}"
            >
                <img width="20px" src="{{Vite::asset('resources/img/previous.svg')}}" alt="Backward arrow">
                <span class="hidden md:inline px-2">Precedente</span>
            </a>
        @endif
            <div class="dropdown text-sm">
            <div tabindex="0" role="button" class="btn btn-error mx-1">Lista Incontri</div>
            <ul tabindex="0" class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52 overflow-y-auto h-60">
                @foreach($games as $gameInBar)
                    @if($gameInBar->started_at >= today() && isset($gameInBar->home_team, $gameInBar->away_team))
                        <li>
                            <a class="@if($game->id === $gameInBar->id) white-bg main-text @else white-text @endif" href="{{route('bet.index', ['game' => $gameInBar])}}">
                                {{$gameInBar->home_team->name}} - {{$gameInBar->away_team->name}}
                            </a>
                        </li>
                    @endif
                @endforeach
                    <details>
                        <summary>Incontri Disputati</summary>
                        <ul>
                            @foreach($games as $gameInBar)
                                @if($gameInBar->started_at < today() && isset($gameInBar->home_team, $gameInBar->away_team))
                                    <li>
                                        <a class="@if($game->id === $gameInBar->id) white-bg main-text @else white-text @endif" href="{{route('bet.index', ['game' => $gameInBar])}}">
                                            {{$gameInBar->home_team->name}} - {{$gameInBar->away_team->name}}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </details>
            </ul>
        </div>
    @if(!$game->isFinal())
        <a class="btn btn-error"
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
            console.log('ciao')
            window.location.assign('{{route('bet.index', ['game' => $gameInBar])}}')
        }
    </script>
@endpush
