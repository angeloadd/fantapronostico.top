<x-layouts.with-drawer>
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
            <div class="col-xl-8">
                <div class="px-3 shadow-lg bg-success text-base-100 mx-3 rounded-md border-success">
                    <div class="w-full px-0 py-0">
                        <div class="row-span-12 p-0 justify-around">
                            <h2 class="text-center fs-1 pt-3 mb-0">
                                {{$game->home_team->name.' vs '.$game->away_team->name}}
                                <br>
                                sarà pronosticabile a partire dalle {{$game->started_at->format('H:i')}}
                                del {{$game->started_at->subDay(1)->format('d ')}} {{ucfirst($game->started_at->subDay(1)->monthName)}} {{$game->started_at->subDay(1)->format(' Y')}}.
                            </h2>
                            <p class="text-center fs-1">Torna più tardi.</p>
                            <div class="w-100 text-base-100 text-center my-3 text-xl">
                                L'incontro si giocherà il
                                <x-_displaydate :date="$game->started_at"/>
                            </div>
                            <div class="flex items-center justify-center display-5 title-font py-3"                            >
                                <x-_countdown :date="$game->started_at"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-_container>
</x-layouts.with-drawer>
