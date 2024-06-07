<x-layouts.with-drawer>
    <x-_game_bar :games="$games" :game="$game"/>
    <div class="row-span-12 justify-center items-center">
        <div class="col-xl-8">
            <div class="px-3 shadow-lg bg-success text-base-100 mx-3 rounded-md border-success">
                <div class="w-full px-0 py-0">
                    <div class="row-span-12 p-0 justify-around">
                        <h2 class="text-center fs-1 pt-3 mb-0">
                            {{__($game->home_team->name).' vs '.__($game->away_team->name)}}
                            <br>
                            sarà pronosticabile dal {{str($game->started_at->subDays($game->isFirstGame() ? 2 : 1)->isoFormat('D MMMM YYYY HH:mm'))->title()}}.
                        </h2>
                        <div class="w-100 text-base-100 text-center my-3 text-xl">
                            L'incontro si giocherà il {{str($game->started_at->isoFormat('D MMMM YYYY HH:mm'))->title()}}
                        </div>
                        <div class="flex items-center justify-center display-5 fp2024-title py-3">
                            <x-partials.countdown.main :date="$game->started_at"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.with-drawer>
