<x-layouts.with-drawer>
            <div class="w-full flex flex-col sm:flex-row justify-evenly items-center">
                <div class="w-full flex flex-col items-center">
                    <div class="card px-3 w-full shadow-lg rounded-lg">
                        <div class="rounded-lg text-center fp2024-title text-2xl py-4 shadow-lg bg-red-600 text-base-100 bg-gradient-to-t from-white/20 via-transparent to-white/20 transition duration-500 ease-in-out hover:-translate-y-4">
                            Ultimi Risultati
                        </div>
                        <div class="card-body">
                            <ul class="menu w-full h-full flex justify-center items-center rounded-box">
                            @foreach($lastThreeGames as $game)
                                <li class="my-1 w-full text-lg bg-red-600/10 rounded-lg">
                                    <a class="flex justify-center items-center" href="{{route('bet.index', compact('game'))}}" role="button">
                                        <img src="{{$game->home_team->logo}}" width="24px" alt="">
                                        <span class="mx-1">{{__($game->home_team->name)}} - {{__($game->away_team->name)}}</span>
                                        <img src="{{$game->away_team->logo}}" width="24px" alt="">
                                    </a>
                                </li>
                            @endforeach
                            </ul>

                        </div>
                    </div>
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
                <div class="w-full card bg-base-100 shadow-xl px-3">
                    <x-_standings :standing="$ranking"/>
                </div>
            </div>
</x-layouts.with-drawer>
