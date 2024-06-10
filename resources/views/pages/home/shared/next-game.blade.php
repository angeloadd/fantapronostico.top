<x-home::shared.card title="Prossimo Incontro" link="{{!empty($game ?? null) ? route('prediction.create', ['game' => $game]) : null}}" linkText="Crea un Pronostico">
    <div @class([
    'flex w-full items-center',
    'justify-center' => !isset($game),
    'justify-between' => isset($game),
])>
        @if(!empty($game ?? null) && !$hasFinalStarted)
            <x-home::shared.team-display :name="$game->home_team->name" src="{{$game->home_team->logo}}" alt="{{$game->home_team->name}} Flag"/>
            <x-home::shared.game-date :date="$game->started_at"/>
            <x-home::shared.team-display :name="$game->away_team->name" src="{{$game->away_team->logo}}" alt="{{$game->away_team->name}} Flag"/>
        @else
            <x-home::shared.illustration img="waiting.svg" alt="A cartoon figure waiting and laying on a tree">
                @if($hasFinalStarted)
                    Attendi il risultato Finale!<br/>È in corso la finale!
                @else
                    Il prossimo Incontro non è Disponibile
                @endif
            </x-home::shared.illustration>
        @endif
    </div>
</x-home::shared.card>
