<x-layout>
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
            <div class="w-full px-0 px-lg-5">
                <ul class="list-group list-group-horizontal row-span-12">
                    <li class="list-group-item col-span-5 col-sm-2 title-font text-bold">Nome Giocatore</li>
                    <li class="list-group-item hidden d-sm-inline lg:hidden col-1 title-font text-bold">
                        1 X 2
                    </li>
                    <li class="list-group-item hidden d-lg-inline col-1 title-font text-bold">
                        Segno
                    </li>
                    <li class="list-group-item hidden d-sm-inline col-2 title-font text-bold">
                        Risultato {{$game->home_team}} vs {{$game->away_team}} </li>
                    <li class="list-group-item col-2 sm:hidden text-2xl">
                        <i class="bi bi-bar-chart-fill text-dark"></i>
                    </li>
                    <li class="list-group-item col-2 hidden d-sm-inline title-font text-bold">
                        Gol/Nogol {{$game->home_team}}
                    </li>
                    <li class="list-group-item col-2 hidden d-sm-inline title-font text-bold">
                        Gol/Nogol {{$game->away_team}}
                    </li>
                    <li class="list-group-item col-span-5 col-sm-3 title-font text-bold">Ultimo Update</li>
                </ul>
                @foreach($sortedBets as $key => $bet)
                    <ul class="list-group list-group-horizontal row-span-12">
                        <li class="list-group-item col-span-5 col-sm-2 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                            <a class="text-decoration-none @if($key%2===0 || Auth::user()?->id === $bet->user->id) text-base-100 @else text-dark @endif"
                               href="{{route('statistics', ['user' => $bet->user])}}">
                                {{$bet->user->full_name}}
                            </a>
                        </li>
                        <li class="list-group-item hidden d-sm-inline col-1 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                            {{$bet->sign}}
                        </li>
                        <li class="list-group-item hidden d-sm-inline col-2 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                            {{$bet->home_result}} a {{$bet->away_result}}
                        </li>
                        <li class="list-group-item col-2 sm:hidden @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                            {{$bet->sign}} ({{$bet->home_result}}-{{$bet->away_result}})
                        </li>
                        <li class="list-group-item hidden d-sm-inline col-2 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                            {{$bet->home_scorer_name}}
                        </li>
                        <li class="list-group-item hidden d-sm-inline col-2 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                            {{$bet->away_scorer_name}}
                        </li>
                        <li class="list-group-item col-span-5 col-sm-3 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif"
                            title="ore {{(new Carbon\Carbon($bet->updated_at))->format('H:i:s')}} e {{(new Carbon\Carbon($bet->updated_at))->format('u')}} millisecondi">
                            {{(new Carbon\Carbon($bet->updated_at))->format('d/m/Y - H:i:s')}}
                        </li>
                    </ul>
                    <div class="row-span-12 justify-center mb-2">

                        <div
                            class="col-span-3 m-0 sm:hidden title-font @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif border border-end-0 border-1 border-info">
                            Gol NoGol
                        </div>
                        <div
                            class="col-7 m-0 sm:hidden @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif border border-1 border-info">
                            {{$bet->home_scorer_name}} - {{$bet->away_scorer_name}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-_bet-card>
</x-layout>
