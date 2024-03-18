<x-layout>
    <div class="w-full px-0 custom-scrollable pb-5">
        <div class="row-span-12 px-0">
            <div class="col-12">
                <div class="container-fluid">
                    <ul class="list-group list-group-horizontal row">
                        <li class="list-group-item col-1 hidden d-sm-flex px-0 px-sm-1">Incontro n°</li>
                        <li class="list-group-item col-4 col-sm-2 px-0 px-sm-1">Partita</li>
                        <li class="list-group-item col-span-3 col-sm-2 px-0 px-sm-1">Risultato</li>
                        <li class="list-group-item col-2 col-sm-1 px-0 px-sm-1">segno</li>
                        <li class="list-group-item col-4 hidden d-sm-flex px-0 px-sm-1">Cartellino</li>
                        <li class="list-group-item col-span-3 col-sm-2 px-0 px-sm-1">Modifica</li>
                    </ul>
                    @foreach($games as $number => $game)
                        <ul class="list-group list-group-horizontal row">
                            <li class="list-group-item col-1 px-0 px-sm-1 title-font hidden d-sm-flex">
                                @if($game->isFinal())
                                    FINALE
                                @else
                                    {{$number+1}}
                                @endif
                            </li>
                            <li class="list-group-item col-4 col-sm-2 px-0 px-sm-1">{{$game->home_team}}
                                vs {{$game->away_team}}</li>
                            <li class="list-group-item col-span-3 col-sm-2 px-0 px-sm-1">{{$game->home_result ?? 'N/A'}}
                                - {{$game->away_result ?? 'N/A'}}</li>
                            <li class="list-group-item col-2 col-sm-1 px-0 px-sm-1">{{$game->sign ?? 'N/A'}}</li>
                            <li class="list-group-item col-2 px-0 px-sm-1 hidden d-sm-flex">
                                @foreach($game->getScoreParsed('home') as $key => $home_scorer)
                                    <p>{{$key+1}}. {{$home_scorer}}</p>
                                @endforeach
                            </li>
                            <li class="list-group-item col-2 px-0 px-sm-1 hidden d-sm-flex">
                                @foreach($game->getScoreParsed('away') as $key => $away_scorer)
                                    <p class="mb-0">{{$key+1}}. {{$away_scorer}}</p>
                                @endforeach
                            </li>
                            <li class="list-group-item col-span-3 col-sm-2 px-0 px-sm-1">
                                <a href="{{route('mod.gameEdit', compact('game'))}}" class="btn btn-danger">
                                    <img class="img-fluid" width="30px" src="{{Vite::asset('resources/img/mods/vai.svg')}}" alt="vai">
                                </a>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>
