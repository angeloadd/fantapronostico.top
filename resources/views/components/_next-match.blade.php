<div class="w-full justify-center items-center">
    <div class="flex flex-col justify-center items-center">
        <div class="flex justify-between items-center w-full">
            <div class="w-full flex flex-col justify-center items-center">
                <div class="w-12 h-12 sm:h-36 sm:w-36 flex justify-center items-center">
                    <img
                        src="{{$nextGame->home_team->logo}}"
                        class="object-cover object-center overflow-hidden"
                        alt="{{$nextGame->home_team->name}} Flag"
                    >
                </div>
                <h3 class="text-lg font-bold text-center whitespace-nowrap">{{__($nextGame->home_team->name)}}</h3>
            </div>
            <div class="text-neutral/50 text-center">
                <p class="font-bold">
                    {{str($nextGame->started_at->isoFormat('D MMMM YYYY'))->title()}}
                </p>
                <p class="text-4xl">
                    {{$nextGame->started_at->format('H:i')}}
                </p>
            </div>
            <div class="flex flex-col w-full justify-center items-center">
                <div class="w-12 h-12 sm:h-36 sm:w-36 flex justify-center items-center">
                    <img
                        src="{{$nextGame->away_team->logo}}"
                        class="object-cover object-center overflow-hidden"
                        alt="{{$nextGame->away_team->name}} Flag"
                    >
                </div>
                <h3 class="text-lg font-bold text-center whitespace-nowrap">{{__($nextGame->away_team->name)}}</h3>
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
