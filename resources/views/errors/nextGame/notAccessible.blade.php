<x-layout>
    <x-_container>
        <x-_game_bar :games="$games" :game="$game"/>
        @if($game->isFinal())
            <div class="row-span-12 justify-center mb-3">
                <div class="col-12">
                    <h2 class="title-font text-center display-1">FINALE</h2>
                </div>
            </div>
        @endif
        <div class="row-span-12 justify-center items-center">
            <div class="col-12 col-xl-8">
                <div class="px-3 shadow-lg bg-success text-base-100 mx-3 rounded-md border-success">
                    <div class="w-full px-0 py-0">
                        <div class="row-span-12 p-0 justify-around">
                            <h2 class="text-center fs-1 pt-3 mb-0">
                                {{$game->home_team.' vs '.$game->away_team}}
                                <br>
                                sarà pronosticabile a partire dalle {{$game->game_date->subDays(1)->format('H:i')}}
                                del {{$game->game_date->format('d ')}} {{ucfirst($game->game_date->monthName)}} {{$game->game_date->format(' Y')}}.
                            </h2>
                            <p class="text-center fs-1">Torna più tardi.</p>
                            <div class="col-12 w-100 text-base-100 text-center my-3 text-xl">
                                L'incontro si giocherà il
                                <x-_displaydate :date="$game->game_date"/>
                            </div>
                            <div class="col-12 flex items-center justify-center display-5 title-font py-3"                            >
                                <x-_countdown :date="$game->game_date"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-_container>
</x-layout>
