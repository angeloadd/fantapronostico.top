<x-_bet-card>
    <div class="flex flex-col h-screen w-full justify-center items-center">
        <div class="card w-full max-w-xl shadow-2xl rounded-xl bg-gradient-to-br from-base-300 via-base-200 to-base-100">
            <div class="grid grid-cols-2 grid-rows-2 sm:grid-cols-3 sm:grid-rows-1 place-items-center p-5 bg-warning rounded-t-xl sm:gap-32">
                <div class="sm:order-1 flex flex-col justify-center items-center">
                    <img
                        src="{{$game->home_team->logo}}"
                        class="w-12 sm:w-36 sm:mask sm:mask-circle"
                        alt="{{__(__($game->away_team->name))}}-Flag"
                    >
                    <h3 class="text-xl font-bold text-center">{{__($game->home_team->name)}}</h3>
                </div>
                <div class="sm:order-3 flex flex-col justify-center items-center">
                    <img
                        src="{{$game->away_team->logo}}"
                        class="w-12 sm:w-36 sm:mask sm:mask-circle"
                        alt="{{$game->away_team->name}} Flag"
                    >
                    <h3 class="text-xl font-bold text-center">{{__($game->away_team->name)}}</h3>
                </div>
                <div class="sm:order-2 col-span-2 sm:col-span-1">
                    <x-partials.countdown.main :date="$game->started_at"/>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-neutral/50 text-center font-bold">
                    Modifica il pronostico entro il
                    {{str($game->started_at->isoFormat('D MMMM YYYY HH:mm'))->title()}}
                </h3>
                <form class="w-full flex flex-col justify-around items-center space-y-5" action="{{route('bet.update', compact('game', 'bet'))}}" method="POST">
                    @csrf
                    @method('put')
                    <div class="w-full flex justify-evenly items-center space-x-2">
                        <label for="home_score" class="label basis-1/3 text-end flex justify-end">
                            Risultato {{__($game->home_team->name)}} @error('home_score')
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
                                value="{{old('home_score', $bet->home_score)}}"
                            >
                            <input
                                type="number"
                                min="0"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                name="away_score"
                                class="input bg-white input-bordered input-xs w-full @error('away_score') border-error @enderror"
                                id="away_score"
                                value="{{old('away_score', $bet->away_score)}}"
                            >
                        </div>
                        <label for="away_score" class="w-full label basis-1/3">
                            Risultato {{__($game->away_team->name)}} @error('away_score')
                            <span class="text-error text-sm">*</span>@enderror
                        </label>
                    </div>

                    <div class="flex items-center justify-evenly w-full max-w-3xl mt-3">
                        <div class="flex justify-center items-center space-x-2 text-sm sm:text-md">
                            <input id="home_victory" type="radio" value="1" name="sign" class="radio bg-white" @if(old('sign', $bet->sign) === '1') checked @endif/>
                            <label for="home_victory">1: {{__($game->home_team->name)}}</label>
                        </div>
                        <div class="flex justify-center items-center space-x-2 text-sm sm:text-md">
                            <input id="draw" type="radio" value="x" name="sign" class="radio bg-white" @if(old('sign', $bet->sign) === 'x') checked @endif/>
                            <label for="draw">X: Pareggio</label>
                        </div>
                        <div class="flex justify-center items-center space-x-2 text-sm sm:text-md">
                            <input id="away_victory" type="radio" value="2" name="sign" class="radio bg-white" @if(old('sign', $bet->sign) === '2') checked @endif/>
                            <label for="away_victory">2: {{__($game->away_team->name)}}</label>
                        </div>
                    </div>
                    <div class="flex space-x-1 justify-center items-center">
                        <label class="label basis-1/6" for="home_scorer_id">
                            Gol {{__($game->home_team->name)}}
                        </label>
                        <select name="home_scorer_id" id="home_scorer_id" class="select select-sm select-bordered w-full max-w-2xl bg-white basis-2/6">
                            <option value="">-- Seleziona un'opzione --</option>
                            <option value="0" @if(old('home_scorer_id', $bet->home_scorer_id) === 0) selected @endif>NoGoal</option>
                            <option value="-1" @if(old('home_scorer_id', $bet->home_scorer_id) === -1) selected @endif> AutoGoal</option>
                            @foreach($game->home_team->players as $player)
                                <option value="{{$player->id}}" @if(old('home_scorer_id', $bet->home_scorer_id) === $player->id) selected @endif>{{$player->displayed_name}}</option>
                            @endforeach
                        </select>
                        <select name="away_scorer_id" id="away_scorer_id"
                                class="select select-sm select-bordered w-full max-w-2xl bg-white basis-2/6">
                            <option value="">-- Seleziona un'opzione --</option>
                            <option value="0" @if(old('away_scorer_id', $bet->away_scorer_id) === 0) selected @endif>
                                NoGol
                            </option>
                            <option value="-1" @if(old('away_scorer_id', $bet->away_scorer_id) === -1) selected @endif>
                                AutoGol
                            </option>
                            @foreach($game->away_team->players as $player)
                                <option
                                    value="{{$player->id}}"
                                    @if(old('away_scorer_id', $bet->away_scorer_id) === $player->id) selected @endif
                                >{{$player->displayed_name}}</option>
                            @endforeach
                        </select>
                        <label
                            class="label basis-1/6 flex justify-center items-center"
                            for="away_scorer_id">
                            Gol {{__($game->away_team->name)}}
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

                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-warning text-base-100 fp2024-title">Modifica</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-_bet-card>
