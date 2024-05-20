<x-_message/>
<div class="w-full card shadow-lg">
    <div class="card-header shadow-lg bg-success text-base-100 mx-3 next-match-header-custom rounded-md border-success">
        <div class="container px-0 py-0">
            <div class=" p-0 justify-around">
                <div
                    class="col-span-5 md:col-span-3 md:order-1 flex flex-col justify-center items-center py-3">
                    <p class="title-font text-2xl m-1">{{$game->home_team->name}}</p>
                    <img src="{{$game->home_team->logo}}" class="img-fluid" width="120" height="80" alt="">
                </div>
                <div
                    class="col-2 flex items-center justify-center display-5 title-font py-3 mt-4 md:hidden">
                    VS
                </div>
                <div
                    class="col-span-5 md:col-span-3 order-md-3 flex flex-col justify-center items-center py-3">
                    <p class="title-font text-2xl m-1">{{$game->away_team->name}}</p>
                    <img src="{{$game->away_team->logo}}" class="img-fluid" width="120" height="80" alt="">
                </div>
                @if(time() < $game->started_at->unix())
                    <div class="col-12 text-base-100 text-center my-3 text-xl">
                        Inizio Incontro il
                        <x-_displaydate :date="$game->started_at"/>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 flex items-center justify-center">
                        <x-_countdown :date="$game->started_at"/>
                    </div>
                @else
                    <div class="col-12 col-md-6 order-md-2 text-base-100 my-3 text-xl flex justify-center items-center flex-col">
                        Incontro disputato il
                        <x-_displaydate :date="$game->started_at"/>
                        <div class="container px-5 mt-3">
                            <div class="">
                                <div class="col-12 border rounded-lg mb-3">
                                    <p class="m-0 w-100 text-center">{{$game->home_team->name}} - {{$game->away_team->name}}</p>
                                    <p class="m-0 w-100 text-center">Risultato 90/120:
                                        <br class="md:hidden">{{$game->home_result}} - {{$game->away_result}} ({{$game->sign}})
                                    </p>
                                </div>
                                <ul class="hidden d-md-block col-6 list-unstyled">
                                    @foreach($game->getScoreParsed('home') as  $key => $scorer)
                                        <li class="fs-6 w-100 text-center">
                                                <span class="border rounded-lg px-1">
                                                    {{$scorer}}
                                                </span>
                                        </li>
                                    @endforeach
                                </ul>
                                <ul class="hidden d-md-block col-6 list-unstyled">
                                    @foreach($game->getScoreParsed('away') as $key => $scorer)
                                        <li class="fs-6 w-100 text-center">
                                                <span class="border rounded-lg px-1">
                                                    {{$scorer}}
                                                </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        {{--                            <br>--}}
                        {{--                            Risultato su partita giocata: {{$game->home_result}} - {{$game->away_result}} ({{$game->sign}})--}}
                        {{--                            <br>--}}
                        {{--                            Gol {{$game->home_team}}:--}}
                        {{--                            @foreach($game->getScoreParsed('home') as  $key => $scorer)--}}
                        {{--                                {{($key+1).'. '.$scorer}}--}}
                        {{--                            @endforeach--}}
                        {{--                            <br>--}}
                        {{--                            Gol {{$game->away_team}}:--}}
                        {{--                            @foreach($game->getScoreParsed('away') as $key => $scorer)--}}
                        {{--                                {{($key+1).'. '.$scorer}}--}}
                        {{--                            @endforeach--}}
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{$slot}}
</div>
