<x-layout>

    <div class="container">
        <div class="row justify-center">
            <div class="offset-md-2 col-8">
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
                        <h5 class="card-title">Vincitore e Capocannoniere</h5>
                        <form action="{{route('mod.updateWinner', compact('champion'))}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="justify-center items-center flex-col w-full px-1">

                                <div
                                    class="mb-3 row justify-center items-center border border-info border-1 pb-4 px-2 rounded-md shadow-lg">
                                    <label for="homeTeam"
                                           class="form-label text-dark flex items-center justify-center">
                                        <p class="m-0 text-center">
                                            Vincitrice Europeo 2020
                                        </p>
                                    </label>
                                    <div class="px-0">
                                        <input type="text" value="" name="champion_team"
                                               class="result-input form-control text-dark @error('champion_team') px-3 is-invalid @enderror"
                                               id="homeTeam">
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mb-3 row justify-center items-center border border-info border-1 pb-4 px-2 rounded-md shadow-lg">
                                <label for="numberOfTopScorer"
                                       class="px-0 form-label text-dark flex items-center justify-center">
                                    <p class="m-0 text-center">
                                        Numero di Capocannonieri
                                    </p>
                                </label>
                                <div class="md:px-2 px-0">
                                    <input type="number" min="0"
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                           name="number_of_scorers"
                                           class="result-input form-control text-dark @error('home_result') px-3 is-invalid @enderror"
                                           id="numberOfTopScorer">
                                </div>

                                @error('away_result')
                                <span class="text-danger flex justify-content-start items-center" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div
                                class="mb-3 px-2 row justify-center items-center border border-1 border-info rounded-md shadow-lg pb-3">
                                <div class="text-dark w-100 text-center my-3">Input
                                    Capocannoniere/i @error('sign')<span
                                        class="text-danger text-bold text-xl">*</span>@enderror </div>
                                <ul class="list-unstyled col-12" id="topScorer"></ul>
                            </div>
                            <div class="row">
                                <div class="justify-around flex items-center">
                                    <button type="submit" class="btn btn-danger text-base-100">Inserisci Info</button>
                                </div>
                            </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
        <script>
            let numberOfTopScorer = document.getElementById('numberOfTopScorer')
            let topScorer = document.getElementById('topScorer')

            function selectTopScorer() {
                topScorer.innerHTML = ''

                let topScorerPlayer = numberOfTopScorer.value

                let i = 1
                while (i <= topScorerPlayer) {

                    li = document.createElement('li')
                    li.classList.add('flex', 'flex-col', 'justify-center', 'items-center', 'pt-2')

                    li.innerHTML =
                        `
                    <label class="form-label px-0 flex justify-center items-center" for="topScorerPlayer${i}">
                        Capocannoniere ${i}
                    </label>
                    <div class="md:px-2 px-0 flex justify-center items-center position-relative" id="topScorerPlayer${i}Container">
                        <input type="text" name="top_scorer${i}" class="result-input form-control text-dark @error('top_scorer') px-3 is-invalid @enderror" id="topScorerPlayer${i}">
                    </div>
                    @error('topScorerPlayer')
                        <span class="text-danger flex justify-content-start items-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                        `
                    i++
                    topScorer.appendChild(li)
                }
            }

            numberOfTopScorer.addEventListener('input', selectTopScorer)

        </script>
    @endpush

</x-layout>
