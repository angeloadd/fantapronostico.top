<x-layouts.with-drawer>
        <div class="row flex justify-center items-center">
            <div class="col-12 col-sm-6">
                @if($isDeadlineForChampionBetPassed)
                    <a class="flex justify-center text-decoration-none text-3xl title-font w-100 rounded-pill border border-1 bg-primary border-primary text-success shadow-lg py-3 px-4"
                       href="{{route('champion.create')}}">
                        <img class="img-fluid" width="25px" src="{{Vite::asset('resources/img/coppaWorldCup.png')}}"
                             alt="cup">
                        <span class="flex text-center justify-center items-center px-3">Vincente e Capocannoniere</span>
                    </a>
                @else
                    <div
                        class="w-100 rounded-pill bg-light border border-1 border-success text-success shadow-lg mt-5 mb-4">
                        <h1 class="my-1 text-center">Benvenuto {{Auth::user()->full_name ?? 'Guest'}}</h1>
                    </div>
                @endif
            </div>
        </div>

        <div class="row flex justify-around items-start">
            <div class="col 12 col-md-6">
                <div class="row flex flex-col items-center">
                    <x-homepage._card>
                        <div class="card-header shadow-lg bg-danger text-base-100 mx-3 standing-header-custom rounded-md border-danger text-center text-3xl title-font">Ultimi Risultati</div>
                        <div class="pt-0 card-body flex flex-col justify-content-evenly items-center">
                            @foreach($lastThreeGames as $game)
                                <a class="btn btn-danger text-base-100 my-1 flex justify-content-evenly items-center" href="{{route('bet.index', compact('game'))}}" role="button">
                                    <img src="{{$game->home->logo}}" height="20px" alt="">
                                    <span class="mx-1">{{$game->home->name}} - {{$game->away->name}}</span>
                                    <img src="{{$game->away->logo}}" height="20px" alt="">
                                </a>
                            @endforeach
                        </div>
                    </x-homepage._card>
                    <x-homepage._card>
                        @if($isFinalStarted)
                            <div
                                class="card-body bg-success flex justify-center items-center flex-col p-3 rounded-md">
                                <h2 class="text-base-100 text-center">È attualmente in corso la finale attendi la fine della
                                    competizione per sapere di quanto hai perso.</h2>
                                <img src="{{Vite::asset('resources/img/table.webp')}}" class="img-fluid rounded-md"
                                     alt="Meme guy lancia il tavolo">
                            </div>
                        @elseif($areGameTeamsSet && isset($nextGame))
                            <x-_next-match :nextGame="$nextGame"/>
                        @else
                            <x-_not-set/>
                        @endif
                    </x-homepage._card>
                </div>
            </div>
            <div class="col-12 col-md-6 flex justify-center items-start">
                <div class="row w-100  flex flex-col items-start">
                    <x-homepage._card>
                        <x-_standings :standing="$ranking"/>
                    </x-homepage._card>
                </div>
            </div>
        </div>
</x-layouts.with-drawer>
