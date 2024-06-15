<x-layouts.with-drawer>
    @if($isWinnerDeclared)
        <x-partials.fireworks.fireworks/>
    @endif
    <div class="w-full h-full grid grid-cols-1 p-2 pt-0 gap-2 place-content-start lg:pt-2 xl:grid-cols-2 xl:grid-rows-3 xl:gap-8 xl:p-8 xl:pt-8">
        <div class="-mb-2 xl:mb-0">
            @if($isWinnerDeclared)
                <x-home::shared.winner :$leagueName :$winnerName />
            @else
                <x-home::shared.next-game :game="$nextGame" :hasFinalStarted="$hasFinalStarted"/>
            @endif
        </div>
        <div class="row-span-3">
            <x-home::shared.ranking :ranking="$ranking"/>
        </div>
        <div>
            <x-home::shared.last-results :$lastResults :$champion/>
        </div>
        <div class="row-start-3">
            <x-home::shared.champion :champion="$champion" :hasTournamentStarted="$hasTournamentStarted"/>
        </div>
    </div>
</x-layouts.with-drawer>
