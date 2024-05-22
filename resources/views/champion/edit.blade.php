<x-layout>
    <x-_champion_card>
        <div class="card-body pt-0">
            <div class="w-full justify-center items-center">
                <div class="justify-center items-center row-span-12">
                    <div class="flex items-center flex-col jsutify-content-center">
                        <h2 class="card-title text-dark display-6 title-font">Pronostico</h2>
                    </div>
                </div>
            </div>
            <form action="{{route('champion.update', compact('champion'))}}" method="POST">
                @csrf
                <div class="justify-center items-center flex-col w-full px-1">
                    <div
                        class="mb-3 px-2justify-center items-center border border-1 border-info rounded-md shadow-lg pb-3">
                        <div class="text-dark w-100 text-center my-3">
                            Inserisci Pronostico
                        </div>
                        <label
                            class="form-label px-0 flex justify-center items-center"
                            for="winner">
                            Vincente @error('winner') <strong class="text-danger">*</strong> @enderror
                        </label>
                        <div
                            class="md:px-2 px-0 flex justify-center items-center position-relative"
                        >
                            <select name="winner"
                                    id="winner"
                                    class="w-100 acc-border rounded-md text-center form-select"
                            >
                                <option value="">-- Seleziona un'opzione --</option>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}"
                                            @if($team->id === $champion->team_id) selected @endif>{{$team->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label
                            class="order-md-last form-label px-0 flex justify-center items-center"
                            for="topScorer">
                            Capocannoniere @error('winner') <strong class="text-danger">*</strong> @enderror
                        </label>
                        <div
                            class="md:px-2 px-0 flex justify-center items-center position-relative"
                        >
                            <select name="topScorer" id="topScorer"
                                    class="w-100 acc-border rounded-md text-center form-select">
                                <option value="" selected>-- Seleziona un'opzione --</option>
                                @foreach($players as $player)
                                    <option
                                        value="{{$player['id']}}"
                                        @if($player['id'] === $champion->player_id) selected @endif>
                                        {{$teams->where(static fn ($team) => $team->id === $player['team_id'])->first()->name}} - {{$player['name']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if(session('errors'))
                        <span class="text-danger flex justify-content-start items-center mb-2" role="alert">
                            <strong>I campi contrassegnati con * sono richiesti</strong>
                        </span>
                    @endif
                    <div class="row-span-12">
                        <div class="justify-around flex items-center">
                            <button type="submit" class="btn btn-warning text-dark">Pronostica</button>
                            <button type="reset" class="btn btn-primary text-base-100">Resetta</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </x-_champion_card>

</x-layout>
