<x-_champion_card>
    <x-partials.heaader.header text="Vincitore e Capocannoniere" bgColor="bg-secondary" />
    <div class="w-full pt-20 px-3 flex justify-center items-center">
        <div role="alert" class="alert alert-error sm:w-3/5">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="w-full flex flex-col justify-between items-center">
                <h3 class="font-bold">Il pronostico non è ancora disponibile</h3>
                <p class="text-xs pb-3">
                    I pronostici saranno aperti dal
                    {{$championSettableFrom->format('d ')}}
                    {{ucfirst($championSettableFrom->monthName)}}
                    {{$championSettableFrom->format(' Y')}}
                    alle
                    {{$championSettableFrom->format('H:i')}}
                </p>
                <x-partials.countdown.main date="{{$championSettableFrom}}"/>
            </div>
        </div>
    </div>
</x-_champion_card>
