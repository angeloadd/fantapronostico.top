<div class="card h-full w-full shadow-lg rounded-lg border border-gray-300 bg-base-100">
    <div class="card-body">
        <div class="w-full flex justify-between items-center">
            <h2 class="card-title pb-2 text-2xl">{{$title}}</h2>
            @if(! empty($link ?? null))
                <a
                        href="{{$link}}"
                        role="button"
                        class="link link-accent text-md text-right lg:text-lg"
                >{{$linkText}}</a>
            @endif
            @if($title === 'Ultimi Risultati')
                <div class="dropdown text-sm">
                    <div tabindex="0" role="button" class="btn-outline btn btn-primary">Lista Incontri
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>

                    </div>
                    <ul tabindex="0" class="shadow menu z-[1] dropdown-content menu-horizontal top-12 left-0 bg-base-100 w-64 overflow-auto h-64 rounded-box">
                        @foreach($games as $gameInBar)
                            <li @class([
                        'hidden' => !$gameInBar->started_at->isFuture() || !isset($gameInBar->home_team, $gameInBar->away_team),
                        'w-full'
                        ])>
                                <a @class([
                        'bg-accent text-accent-content' => $game->id === $gameInBar->id,
                        ]) href="{{route('prediction.index', ['game' => $gameInBar])}}">
                                    {{$gameInBar->home_team->name}} - {{$gameInBar->away_team->name}}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a class="font-bold">Incontri Disputati</a>
                            <ul>
                                @foreach($games as $gameInBar)
                                    <li @class([
                                    'hidden' => !$gameInBar->started_at->isPast() || !isset($gameInBar->home_team, $gameInBar->away_team),
                                ])>
                                        <a
                                            @class([
                                            'text-accent-content bg-accent' => $game->id === $gameInBar->id,
                                            ])
                                            href="{{route('prediction.index', ['game' => $gameInBar])}}">
                                            {{$gameInBar->home_team->name}} - {{$gameInBar->away_team->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
        {{$slot}}
    </div>
</div>
