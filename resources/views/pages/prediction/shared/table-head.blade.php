@php
    $results='Risultato <span class="sm:hidden">%s - %s</span><span class="hidden sm:block">%s - %s</span>';
@endphp

<x-table.head
    :heads="[
    ['text' => '#', 'class' => 'w-12'],
    ['text' => 'Nome'],
    ['text' => 'Segno'],
    ['text' => sprintf($results, $game->home_team->code, $game->away_team->code, __($game->home_team->name), __($game->away_team->name))],
    ['text' => 'Gol/NoGol '.__($game->home_team->name), 'class' => ['hidden' => $game->isGroupStage()]],
    ['text' => 'Gol/NoGol '.__($game->away_team->name), 'class' => ['hidden' => $game->isGroupStage()]],
]"/>
