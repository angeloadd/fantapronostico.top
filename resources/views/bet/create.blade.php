<x-_bet-card :game="$game">
    <x-_game_bar :games="$games" :game="$game"/>
    <div class="w-full max-w-2xl">
        <div class="flex w-full">
            <div class="basis-2/5 flex justify-between items-center flex-row flex-grow card bg-green-400/80 rounded-box p-4">
                <img src="{{$game->home_team->logo}}" class="hidden sm:inline w-24" alt="">
                <p class="w-full text-center fp2024-title font-bold text-2xl">{{$game->home_team->name}}</p>
            </div>
            <div class="divider divider-horizontal">VS</div>
            <div class="basis-2/5 flex flex-row justify-between items-center flex-grow card bg-green-400/80 rounded-box p-4">
                <p class="w-full text-center fp2024-title font-bold text-2xl">{{$game->away_team->name}}</p>
                <img class="hidden sm:inline w-24" src="{{$game->away_team->logo}}" alt="Bandier {{$game->away_team->name}}">
            </div>
        </div>
        @if(time() < $game->started_at->unix())
            <div class="text-center py-2 text-xl">
                Inizio Incontro il
                <x-_displaydate :date="$game->started_at"/>
            </div>
            <div class="flex items-center justify-center">
                <x-_countdown :date="$game->started_at"/>
            </div>
        @else
            <div class="text-xl flex justify-center items-center flex-col">
                Incontro disputato il
                <x-_displaydate :date="$game->started_at"/>
                <div class="container px-5 mt-3">
                    <div class="">
                        <div class="border rounded-lg mb-3">
                            <p class="m-0 w-100 text-center">{{$game->home_team->name}} - {{$game->away_team->name}}</p>
                            <p class="m-0 w-100 text-center">Risultato 90/120:
                                <br class="md:hidden">{{$game->home_score}} - {{$game->away_score}} ({{$game->sign}})
                            </p>
                        </div>
                        <ul class="hidden md:block">
                            @foreach($game->getScoreParsed('home') as  $key => $scorer)
                                <li class="w-full text-center">
                                        <span class="border rounded-lg px-1">
                                            {{$scorer}}
                                        </span>
                                </li>
                            @endforeach
                        </ul>
                        <ul class="hidden md:block">
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
            </div>
        @endif
    </div>

    <form class="w-full flex flex-col justify-center items-center" action="{{route('bet.store', compact('game'))}}" method="POST">
        @csrf
        <p class="text-center">Inserisci Risultato Esatto</p>
        <div class="w-full flex justify-evenly items-center space-x-2">
            <label for="home_score" class="label basis-1/3 flex justify-end">
                Risultato Casa {{$game->home_team->name}} @error('home_score')
                <span class="text-error">*</span>@enderror
            </label>
            <div class="flex justify-center basis-1/3 space-x-1">
                <input
                    type="number"
                    min="0"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                    name="home_score"
                    class="input bg-white input-bordered input-xs w-full @error('home_score') border-error @enderror"
                    id="home_score"
                >
                <input
                    type="number"
                    min="0"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                    name="away_score"
                    class="input bg-white input-bordered input-xs w-full @error('away_score') border-error @enderror"
                    id="away_score"
                >
            </div>
            <label for="away_score" class="w-full label basis-1/3">
                Risultato Ospite {{$game->away_team->name}} @error('away_score')
                <span class="text-error text-sm">*</span>@enderror
            </label>
        </div>

        <p>Segno 1X2 @error('sign')<span class="text-error">*</span>@enderror</p>
        <div class="flex flex-row items-center justify-evenly w-full max-w-3xl mt-3 space-y-2">
            <div class="flex justify-center items-center space-x-2">
                <input id="home_victory" type="radio" value="1" name="sign" class="radio bg-white"/>
                <label for="home_victory">1: Vittoria {{$game->home_team->name}}</label>
            </div>
            <div class="flex justify-center items-center space-x-2">
                <input id="draw" type="radio" value="x" name="sign" class="radio bg-white"/>
                <label for="draw">X: Pareggio</label>
            </div>
            <div class="flex justify-center items-center space-x-2">
                <input id="away_victory" type="radio" value="2" name="sign" class="radio bg-white"/>
                <label for="away_victory">2: Vittoria {{$game->away_team->name}}</label>
            </div>
        </div>
        <p class="text-dark w-100 text-center my-3">Inserisci Pronostico Gol/NoGol (Uno per squadra)
            @error('sign')<span class="text-error text-bold text-xl">*</span>@enderror </p>
        <div class="flex space-x-1 justify-center items-center">
            <label class="label basis-1/6" for="home_scorer_id">
                Gol {{$game->home_team->name}}
            </label>
            <select name="home_scorer_id" id="home_scorer_id" class="select select-sm select-bordered w-full max-w-2xl bg-white basis-2/6">
                <option value="" selected>-- Seleziona un'opzione --</option>
                <option value="0">NoGoal</option>
                <option value="-1"> AutoGoal</option>
                @foreach($game->home_team->players as $player)
                    <option value="{{$player->id}}">{{$player->displayed_name}}</option>
                @endforeach
            </select>
            <select name="away_scorer_id" id="away_scorer_id"
                    class="select select-sm select-bordered w-full max-w-2xl bg-white basis-2/6">
                <option value="" selected>-- Seleziona un'opzione --</option>
                <option value="0" class="text-bold bg-success text-base-100">
                    NoGol
                </option>
                <option value="-1" class="text-bold bg-danger text-base-100">
                    AutoGol
                </option>
                @foreach($game->away_team->players as $player)
                    <option
                        value="{{$player->id}}">{{$player->displayed_name}}
                    </option>
                @endforeach
            </select>
            <label
                class="label basis-1/6 flex justify-center items-center"
                for="away_scorer_id">
                Gol {{$game->away_team->name}}
            </label>
        </div>

        @error('home_scorer_id')
        <span class="text-error flex justify-start items-center">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @error('away_scorer_id')
        <span class="text-error flex justify-start items-center">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <div class="form-control w-full max-w-2xl mt-6">
            <button type="submit" class="btn btn-warning text-base-100 fp2024-title">Pronostica</button>
        </div>
    </form>
</x-_bet-card>
