<x-layout>
    <div class="container">
        <div class="row justify-center">
            <div class="col-8">
                @if(session('message'))
                    <div class="alert alert-success text-center">
                        {{session('message')}}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="container-flui px-0">
        <div class="row px-0">
            <div class="col-12">
                <div class="card text-dark bg-light mb-3">
                    <div class="card-header">Inserisci Informazioni</div>
                    <div class="card-body">
                        <h5 class="card-title">{{$game->home_team ?? 'N/A'}} vs {{$game->away_team ?? 'N/A'}}</h5>
                        <form action="{{route('mod.gameUpdate', compact('game'))}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="justify-center items-center flex-col w-full px-1">
                                @if(!$game->isGroupStage())
                                    <div
                                        class="mb-3 row justify-center items-center border border-info border-1 pb-4 px-2 rounded-md shadow-lg">
                                        <div class="text-dark w-100 text-center my-3 px-0">Squadre</div>
                                        <label for="homeTeam"
                                               class="md:order-1 px-0 form-label text-dark flex items-center justify-center">
                                            <p class="m-0 text-center">
                                                Squadra Casa
                                            </p>
                                        </label>
                                        <div class="order-md-2 md:px-2 px-0">
                                            <input type="text" value="{{$game->home->name ?? null}}" name="home_team"
                                                   class="result-input form-control text-dark @error('home_team') px-3 is-invalid @enderror"
                                                   id="homeTeam">
                                        </div>
                                        <label for="awayTeam"
                                               class="order-md-4 mt-3 mt-md-0 px-0 form-label text-dark flex items-center justify-center">
                                            <p class="m-0 order-md-2 text-center">
                                                Squadra Ospite
                                            </p>
                                        </label>
                                        <div class="md:px-2 px-0 order-md-3">
                                            <input type="text" value="{{$game->away->name ?? null}}" name="away_team"
                                                   class="result-input form-control text-dark @error('away_team') px-3 is-invalid @enderror"
                                                   id="awayTeam">
                                        </div>
                                    </div>
                            </div>
                            @endif
                            <div
                                class="mb-3 row justify-center items-center border border-info border-1 pb-4 px-2 rounded-md shadow-lg">
                                <div class="text-dark w-100 text-center my-3 px-0">Inserisci il risultato esatto
                                    per {{$game->home_team ?? 'N/A'}} vs {{$game->away_team ?? 'N/A'}}.
                                </div>
                                <label for="resultHome"
                                       class="md:order-1 px-0 form-label text-dark flex items-center justify-center">
                                    <p class="m-0 text-center">
                                        Gol Casa
                                    </p>
                                    <span class="text-xl fp2024-title mx-3 flex items-start">
                                        {{$game->home_team ?? ''}}
                                    </span>
                                </label>
                                <div class="order-md-2 md:px-2 px-0">
                                    <input type="number" min="0"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                           name="home_result"
                                           class="result-input form-control text-dark @error('home_result') px-3 is-invalid @enderror"
                                           id="resultHome">
                                </div>
                                <label for="resultAway"
                                       class="order-md-4 mt-3 mt-md-0 px-0 form-label text-dark flex items-center justify-center">
                                    <p class="m-0 order-md-2 text-center">
                                        Gol Ospite
                                    </p>
                                    <span class="md:order-1 text-xl fp2024-title mx-3 flex items-start">
                                        {{$game->away_team ?? ''}}
                                    </span>
                                </label>
                                <div class="md:px-2 px-0 order-md-3">
                                    <input type="number" min="0"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                           name="away_result"
                                           class="result-input form-control text-dark @error('away_result') px-3 is-invalid @enderror"
                                           id="resultAway">
                                </div>
                                @error('home_result')
                                    <span class="text-danger flex justify-content-start items-center" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('away_result')
                                    <span class="text-danger flex justify-content-start items-center" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div
                                class="mb-3 px-2 row justify-center items-center border border-1 border-info rounded-md shadow-lg pb-3">
                                <div class="text-dark w-100 text-center my-3">
                                    Inserisci i Gol fatti @error('sign')<span class="text-danger text-bold text-xl">*</span>@enderror
                                </div>
                                <ul class="list-unstyled col-md-6" id="homeWrapper"></ul>
                                <hr class="d-block md:hidden">
                                <ul class="list-unstyled col-md-6" id="awayWrapper"></ul>
                            </div>
                            <div class="row">
                                <div class="justify-around flex items-center">
                                    <button type="submit" class="btn  btn-error text-base-100">Inserisci Info</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                let homeGol = document.getElementById('resultHome')
                let awayGol = document.getElementById('resultAway')
                let homeWrapper = document.getElementById('homeWrapper')
                let awayWrapper = document.getElementById('awayWrapper')

                function selectGolHome() {
                    homeWrapper.innerHTML = ''

                    let homeScore = homeGol.value

                    let i = 1
                    if (homeScore === '0') {
                        li = document.createElement('li')
                        li.classList.add('flex', 'flex-col', 'justify-center', 'items-center',
                            'pt-2')
                        li.innerHTML =
                            `
                    <label class="form-label px-0 flex justify-center items-center" for="homeScore">
                        Nessun Gol
                    </label>
                    <div class="md:px-2 px-0 flex justify-center items-center position-relative" id="homeScoreContainer">
                        <select name="homeScore" id="homeScore" class="w-100 acc-border rounded-md text-center form-select">
                            <option value="1000000000" class="text-bold bg-success text-base-100">NoGoal</option>
                        </select>
                    </div>
                    @error('homeScore')
                            <span class="text-danger flex justify-content-start items-center" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                            `
                        homeWrapper.appendChild(li)
                    } else if (homeScore > 0) {

                        while (i <= homeScore) {

                            li = document.createElement('li')
                            li.classList.add('flex', 'flex-col', 'justify-center', 'items-center',
                                'pt-2')

                            li.innerHTML =
                                `
                    <label class="form-label px-0 flex justify-center items-center" for="homeScore${i}">
                        Scorer {{$game->home_team}} ${i}
                    </label>
                    <div class="md:px-2 px-0 flex justify-center items-center position-relative" id="homeScore${i}Container">
                        <select name="homeScore${i}" id="homeScore${i}" class="w-100 acc-border rounded-md text-center form-select">
                            <option value="" selected>-- Seleziona un'opzione --</option>
                            <option value="1000000001" class="text-bold bg-danger text-base-100">AutoGoal</option>
                            @foreach($home_team->players as $player)
                                <option value="{{$player->id}}">{{$player->name}}</option>
                            @endforeach
                                </select>
                            </div>
@error('homeScore')
                                <span class="text-danger flex justify-content-start items-center" role="alert">
                                    <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                                `
                            i++
                            homeWrapper.appendChild(li)
                        }
                    }
                }

                homeGol.addEventListener('input', selectGolHome)

                function selectGolAway() {
                    awayWrapper.innerHTML = ''

                    let awayScore = awayGol.value

                    let i = 1
                    if (awayScore === '0') {
                        li = document.createElement('li')
                        li.classList.add('flex', 'flex-col', 'justify-center', 'items-center',
                            'pt-2')
                        li.innerHTML =
                            `
                    <label class="form-label px-0 flex justify-center items-center" for="awayScore">
                        Nessun Gol
                    </label>
                    <div class="md:px-2 px-0 flex justify-center items-center position-relative" id="awayScoreContainer">
                        <select name="awayScore" id="awayScore" class="w-100 acc-border rounded-md text-center form-select">
                            <option value="1000000000" class="text-bold bg-success text-base-100">NoGoal</option>
                        </select>
                    </div>
                    @error('awayScore')
                            <span class="text-danger flex justify-content-start items-center" role="alert">
                                <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                            `
                        awayWrapper.appendChild(li)
                    } else if (awayScore > 0) {

                        while (i <= awayScore) {

                            li = document.createElement('li')
                            li.classList.add('flex', 'flex-col', 'justify-center', 'items-center',
                                'pt-2')

                            li.innerHTML =
                                `
                    <label class="form-label px-0 flex justify-center items-center" for="awayScore${i}">
                        Scorer {{$game->away_team}} ${i}
                    </label>
                    <div class="md:px-2 px-0 flex justify-center items-center position-relative" id="awayScore${i}Container">
                        <select name="awayScore${i}" id="awayScore${i}" class="w-100 acc-border rounded-md text-center form-select">
                            <option value="" selected>-- Seleziona un'opzione --</option>
                            <option value="1000000001" class="text-bold bg-danger text-base-100">AutoGoal</option>
                            @foreach($away_team->players as $player)
                                <option value="{{$player->id}}">{{$player->name}}</option>
                            @endforeach
                                </select>
                            </div>
@error('awayScore')
                                <span class="text-danger flex justify-content-start items-center" role="alert">
                                    <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                                `
                            i++
                            awayWrapper.appendChild(li)
                        }
                    }
                }

                awayGol.addEventListener('input', selectGolAway)
            </script>
    @endpush

</x-layout>
