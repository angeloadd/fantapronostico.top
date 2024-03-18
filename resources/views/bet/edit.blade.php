<x-layout>
    <x-_bet-card :game="$game">
        <div class="card-body pt-0">
            <div class="w-full justify-center items-center">
                <div class="justify-center items-center row-span-12">
                    <div class="col-12 flex items-center flex-col jsutify-content-center">
                        <h2 class="card-title text-dark display-6 title-font">Modifica Pronostico</h2>
                    </div>
                </div>
            </div>
            <form action="{{route('bet.update', compact('bet'))}}" method="POST">
                @csrf
                @method('PUT')
                <div class="justify-center items-center flex-col w-full px-1">

                    <div
                        class="mb-3 row-span-12 justify-center items-center border border-info border-1 pb-4 px-2 rounded-md shadow-lg">
                        <div class="text-dark w-100 text-center col-12 my-3 px-0">Inserisci il risultato
                            esatto per {{$game->home_team}} vs {{$game->away_team}}.
                        </div>
                        <label for="resultHome"
                               class="col-12 md:order-1 px-0 col-md-4 form-label text-dark flex items-center justify-center">
                            <p class="m-0 text-center">
                                Gol Casa
                            </p>
                            <span class="text-xl title-font mx-3 flex items-start">
                                        {{$game->home_team}}
                                    </span>
                        </label>
                        <div class="col-12 order-md-2 col-md-2 px-md-2 px-0">
                            <input value="{{$bet->home_result}}" type="number" min="0"
                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                   name="home_result"
                                   class="result-input form-control text-dark @error('home_result') px-3 is-invalid @enderror"
                                   id="resultHome">
                        </div>
                        <label for="resultAway"
                               class="col-12 order-md-4 col-md-4 mt-3 mt-md-0 px-0 form-label text-dark flex items-center justify-center">
                            <p class="m-0 order-md-2 text-center">
                                Gol Ospite
                            </p>
                            <span class="md:order-1 text-xl title-font mx-3 flex items-start">
                                        {{$game->away_team}}
                                    </span>
                        </label>
                        <div class="col-12 col-md-2 px-md-2 px-0 order-md-3">
                            <input value="{{$bet->away_result}}" type="number" min="0"
                                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                   name="away_result"
                                   class="result-input form-control text-dark @error('away_result') px-3 is-invalid @enderror"
                                   id="resultAway">
                        </div>
                        @error('home_result')
                        <span class="text-danger flex justify-content-start items-center"
                              role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        @error('away_result')
                        <span class="text-danger flex justify-content-start items-center"
                              role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>

                    <div
                        class="mb-3 row-span-12 justify-center items-center flex-col flex-md-row-span-12 text-dark border border-1 rounded-md border-info pb-3 shadow-lg">
                        <div class="text-dark w-100 text-center col-12 my-3">Inserisci Segno
                            1X2 @error('sign')<span class="text-danger text-bold text-xl">*</span>@enderror
                        </div>
                        <div
                            class="form-check col-12 col-md-4 flex justify-content-start justify-content-md-center items-center">
                            <input @if($bet->sign === '1') checked @endif class="form-check-input mx-2 mt-0"
                                   type="radio" name="sign" id="home_victory" value="1">
                            <label class="form-check-label" for="home_victory">
                                1: Vittoria {{$game->home_team}}
                            </label>
                        </div>
                        <div
                            class="form-check col-12 col-md-4 flex justify-content-start justify-content-md-center items-center">
                            <input @if($bet->sign === 'X') checked @endif class="form-check-input mx-2 mt-0"
                                   type="radio" name="sign" value="X" id="draw">
                            <label class="form-check-label" for="draw">
                                X: Pareggio
                            </label>
                        </div>
                        <div
                            class="form-check col-12 col-md-4 flex justify-content-start justify-content-md-center items-center">
                            <input @if($bet->sign === '2') checked @endif class="form-check-input mx-2 mt-0"
                                   type="radio" name="sign" id="away_victory" value="2">
                            <label class="form-check-label" for="away_victory">
                                2: Vittoria {{$game->away_team}}
                            </label>
                        </div>
                        @error('sign')
                        <span class="text-danger flex justify-content-start items-center"
                              role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div
                        class="mb-3 px-2 row-span-12 justify-center items-center border border-1 border-info rounded-md shadow-lg pb-3">
                        <div class="text-dark w-100 text-center col-12 my-3">
                            Inserisci Pronostico Gol/NoGol (Uno per squadra)
                            @error('sign')
                            <span class="text-danger text-bold text-xl">
                                            *
                                        </span>
                            @enderror
                        </div>
                        <label
                            class="form-label col-12 col-md-2 px-0 flex justify-center items-center"
                            for="homeScore">
                            Scorer {{$game->home_team}}
                        </label>
                        <div
                            class="col-12 col-md-4 px-md-2 px-0 flex justify-center items-center position-relative"
                            id="homeScoreContainer">
                            <select name="homeScore" id="homeScore"
                                    class="w-100 acc-border rounded-md text-center form-select">
                                <option value="" selected>-- Seleziona un'opzione --</option>
                                <option value="{{1000000000}}"
                                        @if($bet->home_score === 1000000000) selected
                                        @endif class="text-bold bg-success text-base-100">NoGoal
                                </option>
                                <option value="{{1000000001}}"
                                        @if($bet->home_score === 1000000001) selected
                                        @endif class="text-bold bg-danger text-base-100">AutoGoal
                                </option>
                                @foreach($game->home->players as $player)
                                    <option
                                        @if($bet->home_score === $player->id) selected
                                        @endif value="{{$player->id}}">{{$player->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label
                            class="order-md-2 form-label flex justify-center items-center col-12 col-md-2 px-0 mt-3"
                            for="awayScore">
                            Scorer {{$game->away_team}}
                        </label>
                        <div
                            class="oreder-md-1 col-12 col-md-4 px-md-2 px-0 flex justify-center items-center position-relative"
                            id="awayScoreContainer">
                            <select name="awayScore" id="awayScore"
                                    class="w-100 acc-border rounded-md text-center form-select">
                                <option value="" selected>-- Seleziona un'opzione --</option>
                                <option value="{{1000000000}}"
                                        @if($bet->away_score === 1000000000)
                                            selected
                                        @endif
                                        class="text-bold bg-success text-base-100">
                                    NoGol
                                </option>
                                <option value="{{1000000001}}"
                                        @if($bet->away_score === 1000000001)
                                            selected
                                        @endif
                                        class="text-bold bg-danger text-base-100">
                                    AutoGol
                                </option>
                                @foreach($game->away->players as $player)
                                    <option
                                        @if($bet->away_score === $player->id)
                                            selected
                                        @endif
                                        value="{{$player->id}}">
                                        {{$player->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('homeScore')
                        <span class="text-danger flex justify-content-start items-center"
                              role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        @error('awayScore')
                        <span class="text-danger flex justify-content-start items-center"
                              role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="row-span-12">
                        <div class="col-12 justify-around flex items-center">
                            <button type="submit" class="btn btn-danger text-base-100">
                                Modifica Pronostico
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </x-_bet-card>

</x-layout>
