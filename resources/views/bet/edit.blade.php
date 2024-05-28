<x-_bet-card :game="$game">
    <div class="w-full max-w-2xl sm:py-10">
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
    </div>

    <form class="w-full flex flex-col justify-center items-center" action="{{route('bet.update', compact('bet'))}}" method="POST">
        @method('PUT')
        @csrf
        <p class="text-center">Modifica Risultato Esatto</p>
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
                Risultato Ospite {{$game->away_team->name}} @error('away_score')
                <span class="text-error text-sm">*</span>@enderror
            </label>
        </div>

        <p>Segno 1X2 @error('sign')<span class="text-error">*</span>@enderror</p>
        <div class="flex flex-row items-center justify-evenly w-full max-w-3xl mt-3 space-y-2">
            <div class="flex justify-center items-center space-x-2">
                <input id="home_victory" type="radio" value="1" name="sign" class="radio bg-white" @if(old('sign', $bet->sign) === '1') checked @endif/>
                <label for="home_victory">1: Vittoria {{$game->home_team->name}}</label>
            </div>
            <div class="flex justify-center items-center space-x-2">
                <input id="draw" type="radio" value="x" name="sign" class="radio bg-white" @if(old('sign', $bet->sign) === 'x') checked @endif/>
                <label for="draw">X: Pareggio {{$game->home_team->name}}</label>
            </div>
            <div class="flex justify-center items-center space-x-2">
                <input id="away_victory" type="radio" value="2" name="sign" class="radio bg-white" @if(old('sign', $bet->sign) === '2') checked @endif/>
                <label for="away_victory">2: Vittoria {{$game->home_team->name}}</label>
            </div>
        </div>
        <p class="text-dark w-100 text-center my-3">Modifica Pronostico Gol/NoGol (Uno per squadra)
            @error('sign')<span class="text-error text-bold text-xl">*</span>@enderror </p>
        <div class="flex space-x-1 justify-center items-center">
            <label class="label basis-1/6" for="home_scorer_id">
                Gol {{$game->home_team->name}}
            </label>
            <select name="home_scorer_id" id="home_scorer_id" class="select select-sm select-bordered w-full max-w-2xl bg-white basis-2/6">
                <option value="0" @if(old('home_scorer_id', $bet->home_scorer_id) === '0') selected @endif>NoGoal</option>
                <option value="-1" @if(old('home_scorer_id', $bet->home_scorer_id) === '-1') selected @endif> AutoGoal</option>
                @foreach($game->home_team->players as $player)
                    <option value="{{$player->id}}" @if(old('home_scorer_id', $bet->home_scorer_id) === $player->id) selected @endif>{{$player->displayed_name}}</option>
                @endforeach
            </select>
            <select name="away_scorer_id" id="away_scorer_id"
                    class="select select-sm select-bordered w-full max-w-2xl bg-white basis-2/6">
                <option value="0" @if(old('away_scorer_id', $bet->away_scorer_id) === '0') selected @endif>
                    NoGol
                </option>
                <option value="-1" @if(old('away_scorer_id', $bet->away_scorer_id) === '-1') selected @endif>
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
