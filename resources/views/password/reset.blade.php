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
        <div class="col-12 flex  justify-center items-center">

            <div class="container">
                <div class="row justify-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Modifica Password') }}</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('password.store') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3 row">
                                        <label for="old-password" class="col-md-4 col-form-label text-md-right">{{ __('Vecchia Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="old-password" type="password" class="form-control @error('old-password') is-invalid @enderror" name="old_password" required autocomplete="old-password">

                                            @error('old-password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="mb-3 row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Reset Password') }}
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
