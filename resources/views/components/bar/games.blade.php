@foreach($games as $gameInBar)
    <li @class([
        'hidden' => $hiddenOn($gameInBar) || !isset($gameFromList->home_team, $gameFromList->away_team),
        'w-full'
    ])>
        <a
                @class([
                'text-accent-content bg-accent' => $game->id === $gameInBar->id,
                ])
                href="{{route('prediction.index', ['game' => $gameInBar])}}">
            {{__($gameInBar->home_team->name)}} - {{__($gameInBar->away_team->name)}}
        </a>
    </li>
@endforeach
