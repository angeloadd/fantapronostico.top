<x-home::shared.card title="Pronostico Vincente" link="{{route('champion.index')}}" linkText="Vai ai Pronostici">
    @if(!empty($champion ?? null) && $hasTournamentStarted)
        <x-home::shared.illustration img="forgot_champion.svg" alt="puzzled girl">
            <div class="w-full flex flex-col justify-center items-center">
                <span class="font-normal text-sm">Vincitore</span>
                <span class="text-center lg:text-lg mb-2">{{$champion->team->name}}</span>
                <span class="font-normal text-sm">Capocannoniere</span>
                <span class="text-center lg:text-lg">{{$champion->player->displayed_name}}</span>
            </div>
        </x-home::shared.illustration>
    @else
        <x-home::shared.illustration
            :img="false ? 'forgot_champion.svg' : 'remember_champion.svg'"
            :alt="false ? 'puzzled girl' : 'guy doing ok'"
        >
            @if(false)
                Il Pronostico non<br/> è più Disponibile
            @else
                Pronostica Vincente<br/> e Capocannoniere
            @endif
        </x-home::shared.illustration>
    @endif
</x-home::shared.card>
