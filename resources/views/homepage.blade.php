<x-layouts.with-drawer>
    <div class="flex justify-center items-center w-full h-screen">
        <div class="h-screen w-full sm:grid sm:grid-cols-2 place-items-center justify-items-stretch">
            <div class="h-fit w-full sm:grid sm:grid-rows-2 place-items-center justify-items-stretch">
                <div class="flex h-full w-full justify-center items-center">
                    <x-home-card title="Prossimo Incontro">
                        @isset($nextGame)
                            <x-_next-match :nextGame="$nextGame"/>
                        @else
                            <x-_not-set/>
                        @endisset
                    </x-home-card>
                </div>
                <div class="flex h-full w-full justify-center items-center">
                    <x-home-card title="Ultimi Partite">
                        <ul class="join join-vertical space-y-3">
                            @foreach($lastThreeGames as $game)
                                <li class="pb-1 border-b border-accent/20">
                                    <a class="flex justify-center items-center" href="{{route('bet.index', compact('game'))}}">
                                        <img class="w-7" src="{{$game->home_team->logo}}" alt="{{$game->home_team->name}} Flag">
                                        <span class="basis-1/3 text-right">{{__($game->home_team->name)}}</span>
                                        <span class="basis-1/6 text-center">({{$game->home_score}} - {{$game->away_score}})</span>
                                        <span class="basis-1/3 text-left">{{__($game->away_team->name)}}</span>
                                        <img class="w-7" src="{{$game->away_team->logo}}" alt="{{$game->away_team->name}} Flag">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </x-home-card>
                </div>
            </div>
            <div class="flex h-fit w-full justify-center items-center">
                <x-home-card title="Classifica">
                    <x-_standings :standing="$ranking"/>
                </x-home-card>
            </div>
        </div>
    </div></x-layouts.with-drawer>
