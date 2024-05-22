<x-layout>
        <div class="w-full mt-3">
            <div class="row-span-12 justify-center">
                <div class="col-sm-10 col-md-8">
                    <div class="w-100 rounded-pill bg-light border border-1 border-danger text-danger shadow-lg py-1 px-4">
                        <h2 class="my-1 text-center">Pannello Di Controllo {{Auth::user()->full_name ?? 'Guest'}}</h2>
                    </div>
                </div>
            </div>
            @if(session('message'))
                <div class="row-span-12 justify-center">
                    <div class="col-8">
                        <div class="alert alert-success">
                            {{session('message')}}
                        </div>
                    </div>
                </div>
            @endif
            @if(Auth::user()->admin)
                <div class="row-span-12 justify-center">
                    <div class="col-sm-6 flex justify-center items-center flex-col mt-3">
                        <h2>Abilità Moderatori</h2>
                        <a href="" class="btn btn-warning text-base-100 text-xl">Vai Moderare</a>
                    </div>
                </div>
                <div class="row justify-center">
                    <div class="col-sm-6 flex justify-center items-center flex-col mt-3">
                        <h2>Vincente e Capocannoniere</h2>
                        <a href="{{route('mod.editWinner')}}" class="btn btn-warning text-base-100 text-xl">Inserisci Vincente</a>
                    </div>
                </div>
            @endif
            @if(Auth::user()->games_mod)
                <div class="row justify-center">
                    <div class="col-sm-6 flex justify-center items-center flex-col mt-3">
                        <h2>Gestione Partite</h2>
                        <a href="{{route('mod.gamesIndex')}}" class="btn btn-warning text-base-100 text-xl">Inserisci Risultati</a>
                    </div>
                </div>

            @endif
            @if(Auth::user()->users_mod)
                <div class="row justify-center">
                    <div class="col-sm-6 flex justify-center items-center flex-col mt-3">
                        <h2>Gestione Utenti</h2>
                        <a href="{{route('mod.usersIndex')}}" class="btn btn-warning text-base-100 text-xl">Vai a Gestire</a>
                    </div>
                </div>
            @endif

        </div>
</x-layout>
