@php
    if($hasTournamentStarted){
        $linkText = 'Vai ai Pronostici';
    }elseif(empty($champion ?? null)){
        $linkText = 'Crea Pronostico';
    }else{
        $linkText = 'Modifica Pronostico';
    }
@endphp

<x-home::shared.card
    title="Pronostico Vincente"
    link="{{route('champion.index')}}"
    :$linkText
>
    @if($hasTournamentStarted || !empty($champion ?? null))
        <x-home::shared.illustration img="remember_champion.svg" alt="guy doing ok">
            <div class="w-full flex flex-col justify-center items-center">
                <span class="font-normal text-sm">Vincitore</span>
                <span class="text-center lg:text-lg mb-2">{{__($champion->team->name)}}</span>
                <span class="font-normal text-sm">Capocannoniere</span>
                <span class="text-center lg:text-lg">{{$champion->player->displayed_name}}</span>
            </div>
        </x-home::shared.illustration>
    @else
        <x-home::shared.illustration
            img="remember_champion.svg"
            alt="guy doing ok"
        >
            Pronostica Vincente<br/> e Capocannoniere
        </x-home::shared.illustration>
    @endif

    @if($hasTournamentStarted && empty($champion ?? null))
        <x-home::shared.illustration img="forgot_champion.svg" alt="puzzled girl">
            Il Pronostico non<br/> è più Disponibile
        </x-home::shared.illustration>
    @endif
</x-home::shared.card>
