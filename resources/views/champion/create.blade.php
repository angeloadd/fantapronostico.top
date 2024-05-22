<x-layouts.with-drawer>
    <x-_champion_card>
        <div class="sm:w-full sm:flex sm:justify-center sm:items-center px-2 sm:px-0 py-10">
            <form action="{{route('champion.store')}}" method="POST">
                @csrf
                <div class="form-control max-w-md">
                    <label for="winner" class="label">
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
                <div class="form-control max-w-md">
                    <label for="topScorer" class="label"></label>
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
                <div class="form-control mt-6 max-w-md">
                    <button type="submit" class="btn btn-warning text-base-100 fp2024-title">Pronostica</button>
                </div>
            </form>
        </div>
    </x-_champion_card>
</x-layouts.with-drawer>
