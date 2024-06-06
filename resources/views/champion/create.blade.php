<x-_champion_card>
    <div class="card w-full max-w-xl shadow-2xl rounded-xl bg-gradient-to-br from-base-300 via-base-200 to-base-100">
        <div class="flex flex-col justify-center items-center p-5 bg-secondary rounded-t-xl">
            <h3 class="font-bold text-center text-sm sm:text-lg pb-3">Inserisci il pronostico entro la data di inizio dell'Europeo</h3>
            <div class="flex items-center justify-center">
                <div class="w-12 h-12 sm:h-36 sm:w-36 flex justify-center items-center">
                    <img
                        src="{{\App\Models\Tournament::first()->logo}}"
                        class="object-cover object-center overflow-hidden"
                        alt="{{\App\Models\Tournament::first()->name}} Logo"
                    >
                </div>
                <x-partials.countdown.main date="{{$firstMatchDate}}"/>
            </div>
        </div>
        <div class="card-body">
            <form class="px-3 w-full flex flex-col justify-center items-center" action="{{route('champion.store')}}" method="POST">
                @csrf
                <div class="form-control w-full max-w-2xl mt-6">
                    <label for="winner" class="label">
                        Inserisci un pronostico per la squadra vincente dell'Europeo
                    </label>
                    @error('winner')
                    <span class="text-error text-sm">Campo richiesto</span>
                    @enderror
                    <select name="winner"
                            id="winner"
                            class="select select-bordered bg-white @error('winner') border-error @enderror"
                    >
                        <option value="" @empty(old('winner')) selected @endif>-- Seleziona Squadra Vincente --</option>
                        @foreach($teams as $team)
                            <option value="{{$team->id}}" @if(old('winner') === (string) $team->id) selected @endif>{{$team->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control w-full max-w-2xl mt-6">
                    <label for="topScorer" class="label">Inserisci un pronostico per il Capocannoniere dell'Europeo</label>
                    @error('topScorer')
                    <span class="text-error text-sm">Campo richiesto</span>
                    @enderror
                    <select name="topScorer"
                            id="topScorer"
                            class="select select-bordered bg-white  @error('topScorer') border-error @enderror"
                    >
                        <option value="" @empty(old('topScorer')) selected @endif>-- Seleziona Capocannoniere --</option>
                        @foreach($players as $player)
                            <option value="{{$player['id']}}" @if(old('topScorer') === (string) $player['id']) selected @endif>
                                {{$player['name']}} -
                                {{$teams->where(static fn ($team) => $team->id === $player['team_id'])->first()->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-control w-full max-w-2xl mt-6 card-actions">
                    <button type="submit" class="btn btn-warning text-base-100 fp2024-title m-auto">Pronostica</button>
                </div>
            </form>

        </div>

    </div>
</x-_champion_card>
