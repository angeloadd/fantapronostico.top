<x-layouts.with-drawer>
    <div class="h-screen w-full flex flex-col-reverse place-content-start space-y-2 px-2 pb-2 lg:grid lg:grid-cols-2 lg:space-y-0 lg:gap-10 lg:p-10">
        <div class="space-y-2 mt-2 lg:space-y-10 lg:mt-0">
            <x-home::shared.next-game :game="$nextGame" :hasFinalStarted="$hasFinalStarted"/>
            <x-home::shared.last-results :lastResults="$lastResults"/>
            <x-home::shared.champion :champion="$champion" :hasTournamentStarted="$hasTournamentStarted"/>
        </div>
        <x-home::shared.ranking :ranking="$ranking"/>
    </div>
</x-layouts.with-drawer>
