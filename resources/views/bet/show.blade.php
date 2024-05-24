<x-layouts.with-header>
    <x-_game_bar :games="$games" :game="$game"/>
    @if($game->isFinal())
        <div class="row-span-12 justify-center mb-3">
            <div class="col-12">
                <h2 class="title-font text-center display-1">FINALE</h2>
            </div>
        </div>
    @endif
    <x-_bet-card :game="$game">
        <div class="card-body">
            <ul class="  row-span-12">
                <li class=" col-6 col-sm-2 title-font text-bold">Nome Giocatore</li>
                <li class=" hidden d-sm-inline lg:hidden col-1 title-font text-bold">
                    1 X 2
                </li>
                <li class=" hidden d-lg-inline col-1 title-font text-bold">
                    Segno
                </li>
                <li class=" hidden d-sm-inline col-2 title-font text-bold">
                    Risultato {{$game->home_team}} vs {{$game->away_team}}
                </li>
                <li class=" col-2 hidden d-sm-inline title-font text-bold">
                    Gol/Nogol {{$game->home_team}}
                </li>
                <li class=" col-2 hidden d-sm-inline title-font text-bold">
                    Gol/Nogol {{$game->away_team}}
                </li>
                <li class=" col-6 col-sm-3 title-font text-bold">Ultimo Update</li>
            </ul>
            <ul class=" my-1">
                <li class=" col-6 col-sm-2 bg-primary border-info text-base-100">
                    <a class="text-decoration-none text-base-100"
                       href="{{route('statistics', ['user' => $userBet->user])}}">
                        {{$userBet->user->full_name}}
                    </a>
                </li>
                <li class=" hidden d-sm-inline col-1 bg-primary border-info text-base-100">{{$userBet->sign}}</li>
                <li class=" hidden d-sm-inline col-2 bg-primary border-info text-base-100">{{$userBet->home_result}}
                    a {{$userBet->away_result}}
                </li>
                <li class=" hidden d-sm-inline col-2 bg-primary border-info text-base-100">{{$userBet->home_scorer_name}}</li>
                <li class=" hidden d-sm-inline col-2 bg-primary border-info text-base-100">{{$userBet->away_scorer_name}}</li>
                <li class=" col-6 col-sm-3 bg-primary border-info text-base-100"
                    title="ore {{(new Carbon\Carbon($userBet->updated_at))->format('H:i')}} e {{(new Carbon\Carbon($userBet->updated_at))->format('u')}} millisecondi">
                    {{(new Carbon\Carbon($userBet->updated_at))->format('d/m/Y - H:i:s')}}
                </li>
            </ul>
            <div class="row-span-12 sm:hidden justify-around bg-primary rounded-md py-2 text-dark">
                <div class="col-span-5 bg-light flex justify-center items-center my-1 p-2 rounded-md">
                    Segno
                </div>
                <div
                    class="col-span-5 bg-light my-1 p-2 rounded-md text-3xl flex items-center justify-center">
                    {{$userBet->sign}}
                </div>
                <div class="col-span-5 bg-light flex justify-center items-center my-1 p-2 rounded-md">
                    Risultato {{$game->home_team}}
                </div>
                <div
                    class="col-span-5 bg-light my-1 p-2 rounded-md text-3xl flex items-center justify-center">
                    {{$userBet->home_result}}
                </div>
                <div class="col-span-5 bg-light flex justify-center items-center my-1 p-2 rounded-md">
                    Risultato {{$game->away_team}}
                </div>
                <div
                    class="col-span-5 bg-light my-1 p-2 rounded-md text-3xl flex items-center justify-center">
                    {{$userBet->away_result}}
                </div>

                <div class="col-span-5 bg-light flex justify-center items-center my-1 p-2 rounded-md">
                    Gol/Nogol {{$game->home_team}}
                </div>
                <div
                    class="col-span-5 bg-light my-1 p-2 rounded-md text-xl flex flex justify-center items-center">
                    {{$userBet->home_scorer_name}}
                </div>
                <div class="col-span-5 bg-light flex justify-center items-center my-1 p-2 rounded-md">
                    Gol/Nogol {{$game->away_team}}
                </div>
                <div
                    class="col-span-5 bg-light my-1 p-2 rounded-md text-xl flex flex justify-center items-center">
                    {{$userBet->away_scorer_name}}
                </div>
            </div>

            <div class="row-span-12 justify-center">
                <div class="col-6 flex justify-center my-4">
                    <a href="{{route('bet.edit', ['bet'=> $userBet])}}" class="btn  btn-error text-base-100">
                        Modifica Pronostico
                    </a>
                </div>
            </div>
        </div>
    </x-_bet-card>

</x-layouts.with-header>
