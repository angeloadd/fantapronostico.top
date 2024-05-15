<x-layout>
    <div class="w-full custom-scrollable py-5">
        @if(Auth::user()->users_mod)
            <div class="row justify-center">
                <div class="col-8">
                    <div class="w-100 rounded-pill bg-light border border-1 border-danger text-danger shadow-lg py-1 px-4">
                        <h2 class="my-1 text-center">Pannello Di Controllo</h2>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <h2 class="my-1 text-center">Lista Utenti</h2>
                    <div class="w-full py-1 px-0">
                        <ul class="list-group list-group-horizontal row justify-center">
                            <li class="list-group-item px-0 px-md-3 col-2 title-font flex justify-center items-center">
                                #
                            </li>
                            <li class="list-group-item px-0 px-md-3 col-7 col-md-4 title-font flex justify-center items-center">
                                Nome Giocatore
                            </li>
                            <li class="list-group-item px-0 px-md-3 col-span-3 col-md-2 title-font flex justify-center items-center">
                                Gestisci
                            </li>
                        </ul>

                        @foreach($users as $key => $user)
                            <ul class="list-group list-group-horizontal row justify-center">
                                <li class="list-group-item px-0 px-md-3 col-2 title-font flex justify-center items-center text-2xl">{{$key +1}}</li>
                                <li class="list-group-item px-0 px-md-3 col-7 col-md-4 title-font flex justify-center items-center text-2xl">{{$user->full_name}}</li>
                                <li class="list-group-item px-0 px-md-3 col-span-3 col-md-2 title-font flex justify-center items-center">
                                    <a href="{{route('mod.userEdit', compact('user'))}}"
                                       class="btn btn-warning text-base-100">Vai</a>
                                </li>
                            </ul>
                        @endforeach

                        <ul class="list-group list-group-horizontal row justify-center">
                            <li class="list-group-item col-6 col-md-4 title-font flex justify-center items-center">
                                Nuovo Utente
                            </li>
                            <li class="list-group-item col-6 col-md-4 title-font flex justify-center items-center">
                                <a href="{{route('mod.userCreate')}}" class="btn btn-success text-base-100">Crea</a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        @endif

    </div>
</x-layout>