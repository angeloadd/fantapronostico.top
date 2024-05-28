<x-layout>
    <div class="w-full px-0 custom-scrollable pb-5">
        <div class="row-span-12 px-0">
            <div class="col-12">
                <div class="container-fluid">
                    <ul class="  row">
                        <li class=" col-1 hidden sm:flex px-0 px-sm-1">Incontro n°</li>
                        <li class=" col-4title px-0 px-sm-1">Partita</li>
                        <li class="title px-0 px-sm-1">Risultato</li>
                        <li class=" col-sm-1 px-0 px-sm-1">segno</li>
                        <li class=" col-4 hidden sm:flex px-0 px-sm-1">Cartellino</li>
                        <li class="title px-0 px-sm-1">Modifica</li>
                    </ul>
                    @foreach($games as $number => $game)
                        <ul class="  row">
                            <li class=" col-1 px-0 px-sm-1 fp2024-title hidden sm:flex">
                                @if($game->isFinal())
                                    FINALE
                                @else
                                    {{$number+1}}
                                @endif
                            </li>
                            <li class=" col-4title px-0 px-sm-1">{{$game->home_team}}
                                vs {{$game->away_team}}</li>
                            <li class="title px-0 px-sm-1">{{$game->home_result ?? 'N/A'}}
                                - {{$game->away_result ?? 'N/A'}}</li>
                            <li class=" col-sm-1 px-0 px-sm-1">{{$game->sign ?? 'N/A'}}</li>
                            <li class=" px-0 px-sm-1 hidden sm:flex">
                                @foreach($game->getScoreParsed('home') as $key => $home_scorer)
                                    <p>{{$key+1}}. {{$home_scorer}}</p>
                                @endforeach
                            </li>
                            <li class=" px-0 px-sm-1 hidden sm:flex">
                                @foreach($game->getScoreParsed('away') as $key => $away_scorer)
                                    <p class="mb-0">{{$key+1}}. {{$away_scorer}}</p>
                                @endforeach
                            </li>
                            <li class="title px-0 px-sm-1">
                                <a href="{{route('mod.gameEdit', compact('game'))}}" class="btn  btn-error">
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
