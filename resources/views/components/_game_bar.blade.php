<div class="row-span-12 justify-center items-center m-5" id="gameBar">
    <div class="col-12 flex justify-center items-center dropdown-center">
        <div class="w-full flex justify-center items-center">
            <div class="btn-group" role="group" aria-label="Basic example">
                @if(!$game->isFirstGame())
                    <a class="border-danger bg-danger flex justify-content-evenly items-center btn game-bar-dropdown text-base-100"
                       id="previousGameBtn"
                       href="{{route('bet.previousFromReference', compact('game'))}}" role="button">
                        <img width="20px" src="{{Vite::asset('resources/img/previous.svg')}}" alt="Backward arrow">
                        <span class="hidden d-md-inline px-2">Precedente</span>
                    </a>
                @endif
                <div class="dropdown-center">
                    <button class="mx-2 border-danger bg-danger flex justify-center items-center btn dropdown-toggle white-text game-bar-dropdown rounded-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Lista incontri
                    </button>
                    <ul class="dropdown-menu main-bg white-text">
                        @foreach($games as $gameInBar)
                            @if($gameInBar->game_date < today())
                            @elseif(isset($gameInBar->home, $gameInBar->away))
                                <li>
                                    <a class="dropdown-item text-center @if($game->id === $gameInBar->id) white-bg main-text @else white-text @endif text-3xl" href="{{route('bet.index', ['game' => $gameInBar])}}">
                                        {{$gameInBar->home_team}} - {{$gameInBar->away_team}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                            <hr/>
                            <p class="text-center">Incontri passati</p>
                        @foreach($games as $gameInBar)
                            @if($gameInBar->game_date < today() && isset($gameInBar->home, $gameInBar->away))
                                <li>
                                    <a class="dropdown-item text-center text-3xl @if($game->id === $gameInBar->id) white-bg main-text @else white-text @endif" href="{{route('bet.index', ['game' => $gameInBar])}}">
                                        {{$gameInBar->home_team}} - {{$gameInBar->away_team}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                </div>
                @if(!$game->isFinal())
                    <a class="border-danger bg-danger flex justify-content-evenly items-center btn game-bar-dropdown text-base-100"
                       id="nextGameBtn"
                        href="{{route('bet.nextFromReference', compact('game'))}}" role="button">
                        <span class="hidden d-md-inline px-2">Prossimo</span>
                        <img width="20px" src="{{Vite::asset('resources/img/next.svg')}}" alt="Foreward arrow">
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function goTo(){
            console.log('ciao')
            window.location.assign('{{route('bet.index', ['game' => $gameInBar])}}')
        }
    </script>
@endpush
