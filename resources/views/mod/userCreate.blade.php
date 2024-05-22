<x-layout>
    <div class="container">
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
            <div class="flex  justify-center items-center">
                <div class="container">
                    <div class="row justify-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Crea Nuovo Utente</div>

                                <div class="card-body">
                                    <form method="POST" action="{{ route('mod.userStore') }}">
                                        @csrf

                                        <div class="mb-3 row">
                                            <label for="name"
                                                   class="col-form-label text-md-right">Nome</label>

                                            <div class="col-md-6">
                                                <input id="name" value="{{old('name')}}" type="text"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       name="name">

                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="surname"
                                                   class="col-form-label text-md-right">Cognome</label>

                                            <div class="col-md-6">
                                                <input id="surname" value="{{old('surname')}}" type="text"
                                                       class="form-control @error('surname') is-invalid @enderror"
                                                       name="surname">

                                                @error('surname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Crea
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
</x-layout>
