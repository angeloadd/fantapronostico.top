<x-partials.notifications.toast-message />

<div class="flex flex-col justify-center items-center w-full space-y-1">
    <h2 class="text-xl">
        {{__('auth.verify_email.salutation', ['username' => Auth::user()->name])}}
    </h2>
    <h1 class="text-2xl">Inscriviti ad una lega!</h1>
    <form action="{{route('leagues.subscribe')}}" method="POST">
        @csrf
        <div class="w-full flex flex-col justify-center items-center mt-6">
            <div class="w-full flex flex-col justify-center items-center">

                <label for="league_id">Scegli una delle lege presenti ed iscriviti.</label>
                <select class="select select-bordered w-full max-w-xs bg-white mt-6" name="league_id" id="league_id">
                    @foreach($leagues as $league)
                        <option value="{{$league->id}}">{{$league->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-center items-center mt-6">

                <button class="btn btn-primary">Richiedi Iscrizione</button>
            </div>

        </div>

    </form>
</.div>
