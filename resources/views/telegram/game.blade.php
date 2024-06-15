<a href="{{route('prediction.create', compact('game'))}}">
    {{route('prediction.create', compact('game'))}}
</a>
<strong>{{$game->home_team->name}}</strong> - <strong>{{$game->away_team->name}}</strong>
<strong>{{str($game->started_at->isoFormat('\e\n\t\r\o \i\l D MMMM YYYY \a\l\l\e HH:mm'))->title()}}</strong>
