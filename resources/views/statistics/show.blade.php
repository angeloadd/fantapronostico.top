<x-layout>
        <div class="row p-3">
            <div class="card col main-bg white-text">
                <div class="card-body">
                    <h5 class="card-title text-4xl fp2024-title">
                        @if($userRank->user()->id === auth()?->user()?->id)
                            Le tue statistiche
                        @else
                            Le statistiche di {{$userRank->user()->full_name}}
                        @endif
                    </h5>
                    <ul class="list-group-horizontal py-3">
                        <li class="">
                            <div class="w-full p-0 justify-center">
                                <div class="row justify-around">
                                    <div class="col-1 fp2024-title flex justify-around items-center text-xl">
                                        #
                                    </div>
                                    <div class="title-font flex justify-around items-center text-xl">
                                        Nome
                                    </div>
                                    <div class="title-font flex justify-around items-center text-xl">
                                        Punti
                                    </div>
                                    <div class="title-font hidden sm:flex justify-around items-center text-xl">
                                        Esatti
                                    </div>
                                    <div class="title-font hidden sm:flex justify-around items-center text-xl">
                                        Segni
                                    </div>
                                    <div class="title-font hidden sm:flex justify-around items-center text-xl">
                                        Gol
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class=" rounded-lg @if(Auth::user()?->id === $userRank->user()->id) bg-secondary white-text @else white-bg main-text @endif">
                            <div class="w-full p-0 justify-center ">
                                <div class="row justify-around">
                                    <div class="col-1 flex justify-center items-center text-2xl">
                                        @if($userPosition +1 === 1)
                                            <span class="badge rounded-pill first-place">{{$userPosition+1}}</span>
                                        @elseif($userPosition+1 === 2)
                                            <span class="badge rounded-pill second-place">{{$userPosition+1}}</span>
                                        @elseif($userPosition+1 === 3)
                                            <span class="badge rounded-pill third-place">{{$userPosition+1}}</span>
                                        @elseif(in_array(($userPosition+1), [4, 5, 6], true))
                                            <span class="badge rounded-pill bg-success">{{$userPosition+1}}</span>
                                        @elseif(in_array(($userPosition+1), [7, 8], true))
                                            <span class="badge rounded-pill main-bg">{{$userPosition+1}}</span>
                                        @elseif($userPosition+1 === 63)
                                            <span class="badge rounded-pill sec-bg">{{$userPosition+1}}</span>
                                        @else
                                            <span class="rounded-pill badge @if(Auth::user()?->id !== $userRank->user()->id) main-text @endif">{{$userPosition+1}}</span>
                                        @endif
                                    </div>
                                    <div class="flex justify-center text-center items-center text-2xl">
                                        {{$userRank->user()->full_name}}
                                    </div>
                                    <div class="flex justify-center items-center text-2xl">
                                        {{$userRank->total()}}
                                    </div>
                                    <div class="hidden sm:flex justify-center items-center text-2xl">
                                        {{$userRank->results()}}
                                    </div>
                                    <div class="hidden sm:flex justify-center items-center text-2xl">
                                        {{$userRank->signs()}}
                                    </div>
                                    <div class="hidden sm:flex justify-center items-center text-2xl">
                                        {{$userRank->scorers()}}
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav nav-tabs col" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="bets-tab" data-bs-toggle="tab" data-bs-target="#bets-tab-pane" type="button" role="tab" aria-controls="bets-tab-pane" aria-selected="true">Pronostici</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Statistiche</button>
            </li>
        </ul>
        <div class="tab-content p-3" id="myTabContent">
            <div class="tab-pane fade show active" id="bets-tab-pane" role="tabpanel" aria-labelledby="bets-tab" tabindex="0">
                @foreach($userBets as $key => $bet)
                    @if($bet->game->timestamp > time() && auth()->user()->id !== $userRank->user()->id)
                        @php
                            {{continue;}}
                        @endphp
                    @endif
                    <ul class="  row">
                        <li class=" col-4 @if($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                            <div class="container px-0 px-xl-5">
                                <div class="row">
                                    <div class="col-lg-8 border rounded-lg">
                                        <p class="m-0 text-center">{{$bet->game->home_team}} - {{$bet->game->away_team}}</p>
                                        <p class="m-0 text-center">Risultato 90/120: <br class="md:hidden">{{$bet->game->home_result}} - {{$bet->game->away_result}} ({{$bet->game->sign}})</p>
                                    </div>
                                    <div class="col-lg-4 flex justify-center items-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-success p-0 p-lg-1 dropdown-toggle fs-6" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Cartellino
                                            </button>
                                            <div class="dropdown-menu">
                                                <div class="w-full w-100">
                                                    <div class="row">
                                                        <ul class="list-unstyled">
                                                            <li class="w-100 text-center">{{$bet->game->home_team}}</li>
                                                            @foreach($bet->game->getScoreParsed('home') as  $scorer)
                                                                <li class="fs-6 w-100 text-center">
                                                                    <span class="border rounded-lg px-1">
                                                                        {{$scorer}}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <ul class="list-unstyled">
                                                            <li class="w-100 text-center">{{$bet->game->away_team}}</li>
                                                            @foreach($bet->game->getScoreParsed('away') as $scorer)
                                                                <li class="fs-6 w-100 text-center">
                                                                    <span class="border rounded-lg px-1">
                                                                        {{$scorer}}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class=" col-4 flex justify-center items-center text-center @if($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                            {{$bet->sign}} ({{$bet->home_result}}-{{$bet->away_result}})
                            <br>
                            {{$bet->home_scorer_name}} / {{$bet->away_scorer_name}}

                        </li>
                        <li class=" col-4 flex justify-center items-center @if($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                            @if($bet->game->timestamp > time() && auth()->user()->id === $userRank->user()->id)
                                <a class="btn  btn-error text-base-100" role="button" href="{{route('bet.index', ['game' => $bet->game])}}">
                                    Modifica
                                </a>
                            @else
                                {{$userRank->calculateResultOfTheBet($bet)}}
                            @endif
                        </li>
                    </ul>
                @endforeach
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <p>
                    <span class="text-2xl fp2024-title">Pronostici Fatti:</span>
                    <span class="text-2xl">{{$userBets->count()}}</span>
                </p>
                <p>
                    <span class="text-2xl fp2024-title">Media punti per pronostico:</span>
                    <span class="text-2xl">{{number_format($userRank->total() / $userBets->count(), 2)}}</span>
                </p>
                @if(time() > \App\Helpers\Constants::FINAL_DATE)
                <p>
                    <span class="text-2xl fp2024-title">Info Pronostico Finale:</span>
                    <span class="text-2xl">{{$userRank->finalBetTotal() ?: 'N/A'}} pronosticato in data e ora: {{\Carbon\Carbon::createFromTimestamp($userRank->finalBetTimestamp())->format(\App\Helpers\Constants::DATE_FORMAT) ?: 'N/A'}}</span>
                </p>
                @endif
                <p>
                    <span class="text-2xl fp2024-title">Pronostico Vincente:</span>
                    <span class="text-2xl">{{$userRank->user()->champion ? $userRank->user()->champion->team->name : 'Non pronosticato'}} - tot:{{$userRank->winner()}}</span>
                </p>
                <p>
                    <span class="text-2xl fp2024-title">Pronostico Capocannoniere:</span>
                    <span class="text-2xl">{{$userRank->user()->champion ? $userRank->user()->champion->player->name : 'Non pronosticato'}} - tot:{{$userRank->top()}}</span>
                </p>
            </div>
        </div>
</x-layout>
