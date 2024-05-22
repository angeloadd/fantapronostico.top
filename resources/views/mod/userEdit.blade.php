<x-layout>
    <div class="container mt-5">
        @if(session('message'))
            <div class="row justify-center">
                <div class="col-8">
                    <div class="alert alert-success">
                        {{session('message')}}
                    </div>
                </div>
            </div>
        @endif
        @if(session('error_message'))
            <div class="row justify-center">
                <div class="col-8">
                    <div class="alert alert-danger">
                        {{session('error_message')}}
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="flex justify-center items-center">
                <div class="container">
                    <div class="row justify-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Gestisci {{$user->full_name}}</div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('mod.userUpdate', compact('user')) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3 row mb-0">
                                            <div class="col-sm-6 flex justify-center">
                                                <button type="submit" class="btn btn-success text-base-100">
                                                    Resetta Utente
                                                </button>
                                            </div>
                                            <div class="col-sm-6 mt-2 mt-sm-0 flex justify-center">
                                                <button type="button" class="btn btn-danger text-base-100"
                                                        data-bs-toggle="modal" data-bs-target="#deleteUser">
                                                    Cancella Utente
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserLabel">Cancella {{$user->full_name}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('mod.userDelete',compact('user'))}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Sei sicuro di voler eliminare l'utente: {{$user->full_name}}?
                        <label for="deleteUserInput" class="text-danger">Inserisci qui il tuo nome
                            ({{Auth::user()->full_name}}) per procedere alla cancellazione</label>
                        <input id="deleteUserInput" class="form-control" type="text" name="mod" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-primary text-base-100">Cancella {{$user->full_name}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
