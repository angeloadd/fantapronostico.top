<x-layout>

    <div class="container">
        <div class="row-span-12 justify-center">
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
                        <h5 class="card-title">{{$game->home_team ?? 'N/A'}} vs {{$game->away_team ?? 'N/A'}}</h5>
                        <form action="{{route('mod.setGame', compact('game'))}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="justify-center items-center flex-col w-full px-1">
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
                                        <input type="text" value="{{$game->home_team ?? ''}}" name="home_team"
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
                                        <input type="text" value="{{$game->away_team ?? ''}}" name="away_team"
                                               class="result-input form-control text-dark @error('away_team') px-3 is-invalid @enderror"
                                               id="awayTeam">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="justify-around flex items-center">
                                    <button type="submit" class="btn  btn-error text-base-100">Inserisci Info</button>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</x-layout>
