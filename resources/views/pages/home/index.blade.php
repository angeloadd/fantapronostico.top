<x-layouts.with-drawer>
    @if($isWinnerDeclared)
        <x-partials.fireworks.fireworks/>
    @endif
    <div class="w-full h-full grid grid-cols-1 p-2 pt-0 gap-2 lg:grid-cols-2 lg:grid-rows-3 lg:gap-8 lg:p-8 lg:pt-8 place-content-start">
        <div>
            @if($isWinnerDeclared)
                <x-home::shared.card title="Vincitore">
                    <x-home::shared.illustration img="award.svg" alt="awards cerimony illustration">
                        <p class="font-normal">Il vincitore della lega {{$leagueName}} è</p>
                        <h2 class="text-3xl fp2024-title font-bold">{{$winnerName}}</h2>
                    </x-home::shared.illustration>
                </x-home::shared.card>
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
