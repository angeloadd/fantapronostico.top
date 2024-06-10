<thead>
    <tr class="border-base-300 [&>*]:text-center">
        <th>#</th>
        <th>Nome</th>
        <th>Segno</th>
        <th>
            <span>Risultato</span>
            <span class="sm:hidden">
                       {{__($game->home_team->code)}} - {{__($game->away_team->code)}}
                    </span>
            <span class="hidden sm:block">
                        {{__($game->home_team->name)}} - {{__($game->away_team->name)}}
                    </span>
        </th>
        @if(!$game->isGroupStage())
            <th>Gol/NoGol {{__($game->home_team->name)}}</th>
            <th>Gol/NoGol {{__($game->away_team->name)}}</th>
        @endif
    </tr>
</thead>
