<x-home::shared.card title="Ultimi Partite">
    <ul class="join join-vertical space-y-3">
        @foreach($lastResults as $game)
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
</x-home::shared.card>
