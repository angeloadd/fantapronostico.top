<div class="w-full justify-center items-center">
    <div>

    </div>
    <div class="flex flex-col justify-center items-center">
        <div class="flex justify-between items-center w-full">
            <div>
                <div class="w-12 sm:w-36 mask mask-circle">
                    <img
                        src="{{$nextGame->home_team->logo}}"
                        class="object-center object-fill"
                        alt="{{__(__($nextGame->away_team->name))}}-Flag"
                    >
                </div>
                <h3 class="text-xl font-bold text-center">{{__($nextGame->home_team->name)}}</h3>
            </div>
            <div class="text-neutral/50 text-center">
                <p class="font-bold">
                    {{str($nextGame->started_at->isoFormat('D MMMM YYYY'))->title()}}
                </p>
                <p class="text-4xl">
                    {{$nextGame->started_at->format('H:i')}}
                </p>
            </div>
            <div>
                <div class="w-12 sm:w-36 mask-circle mask">
                    <img
                        src="{{$nextGame->away_team->logo}}"
                        class="object-fill object-center"
                        alt="{{$nextGame->away_team->name}} Flag"
                    >
                </div>
                <h3 class="text-xl font-bold text-center">{{__($nextGame->away_team->name)}}</h3>
            </div>
        </div>

    </div>
    <div class="pt-7 card-actions justify-end">
        <a
            href="{{route('bet.create', ['game' => $nextGame])}}"
            role="button"
            class="btn btn-primary">Pronostica</a>
    </div>
</div>
