<x-layouts.with-drawer>
    <div class="w-full h-full grid grid-cols-1 p-2 pt-0 gap-2 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8 lg:p-8 lg:pt-8 place-content-start">
        <div class="">
            <x-home::shared.next-game :game="$nextGame" :hasFinalStarted="$hasFinalStarted"/>
        </div>
        <div class="row-span-3">
            <x-home::shared.ranking :ranking="$ranking"/>
        </div>
        <div class="">
            <x-home::shared.last-results :lastResults="$lastResults"/>
        </div>
        <div class="row-start-3">
            <x-home::shared.champion :champion="$champion" :hasTournamentStarted="$hasTournamentStarted"/>
        </div>
    </div>
</x-layouts.with-drawer>
