<div class="shadow-lg bg-success text-base-100 mx-3 next-match-header-custom rounded-md border-success">
    <div class="w-full flex">
        <div class="flex basis-2/5 justify-start items-center">
            <span class="fp2024-title text-2xl m-1">{{$nextGame->home_team->name}}</span>
        </div>
        <div class="divider basis-1/5 divider-horizontal">VS</div>
        <div class="flex basis-2/5 justify-end items-center">
            <span class="fp2024-title text-2xl m-1">{{$nextGame->away_team->name}}</span>
        </div>
    </div>
</div>
<div class="card-body w-full justify-center items-center">
    <div class="flex justify-center items-center">
        <div class="basis-1/3">
            <img
                src="{{$nextGame->away_team->logo}}"
                class="hidden sm:inline w-24"
                alt="{{$nextGame->away_team->name}}-Flag"
            >
        </div>
        <div class="basis-1/3">
            <p class="text-center">
                Si disputerà il
                {{$nextGame->started_at->format('d ')}}
                {{ucfirst($nextGame->started_at->monthName)}}
                {{$nextGame->started_at->format(' Y')}}
                ore {{$nextGame->started_at->format('H:i')}}
            </p>
        </div>
       <div class="basis-1/3 text-end">
           <img
               src="{{$nextGame->home_team->logo}}"
               class="hidden sm:inline w-24"
               alt="{{$nextGame->home_team->name}}-Flag"
           >
       </div>
    </div>
    <div class="w-full flex items-center justify-center">
        <a
            href="{{route('bet.create', ['game' => $nextGame])}}"
            role="button"
            class="btn btn-success">Pronostica</a>
    </div>
</div>
