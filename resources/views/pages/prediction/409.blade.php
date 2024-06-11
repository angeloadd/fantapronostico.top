<x-prediction::shared.layout>
    <x-prediction::shared.game-bar :games="$games" :game="$game"/>
    <div class="flex justify-center items-center">
        <div role="alert" class="alert alert-warning flex flex-col justify-center items-center shadow-lg text-lg">
            <h3 class="text-center">
                <span class="font-bold">{{__($game->home_team->name).' vs '.__($game->away_team->name)}}</span>
                <br>
                sarà pronosticabile dal {{str($game->started_at->subDays($game->isFirstGame() ? 2 : 1)->isoFormat('D MMMM YYYY HH:mm'))->title()}}.
            </h3>
            <div class="text-center">
                L'incontro si giocherà il {{str($game->started_at->isoFormat('D MMMM YYYY HH:mm'))->title()}}
            </div>
            <x-partials.countdown.main bgColor="bg-yellow-500" :date="$game->started_at"/>
        </div>
    </div>
</x-prediction::shared.layout>
