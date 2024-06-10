<x-layouts.with-drawer>
    <div class="h-full w-full justify-center items-start">
        <x-partials.header.header text="Pronostico" bgColor="bg-primary"/>
        <x-prediction::shared.game-bar :games="$games" :game="$game"/>
        <div class="flex w-full justify-center items-center">
            <div class="px-3 w-full sm:w-1/2 shadow-lg bg-warning mx-3 rounded-md border-success">
                <h2 class="text-center fs-1 pt-3 mb-0">
                    {{__($game->home_team->name).' vs '.__($game->away_team->name)}}
                    <br>
                    sarà pronosticabile dal {{str($game->started_at->subDays($game->isFirstGame() ? 2 : 1)->isoFormat('D MMMM YYYY HH:mm'))->title()}}.
                </h2>
                <div class="w-100 text-center my-3 text-xl">
                    L'incontro si giocherà il {{str($game->started_at->isoFormat('D MMMM YYYY HH:mm'))->title()}}
                </div>
                <div class="flex items-center justify-center display-5 fp2024-title py-3">
                    <x-partials.countdown.main bgColor="bg-yellow-500" :date="$game->started_at"/>
                </div>
            </div>
        </div>

    </div>
</x-layouts.with-drawer>
