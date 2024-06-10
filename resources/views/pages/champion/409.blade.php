<x-champion::shared.layout>
    <div class="p-2 sm:p-8 flex justify-center items-center">
        <div role="alert" class="alert alert-warning flex flex-col justify-center items-center shadow-lg">
            <h3 class="font-bold">Il pronostico non è ancora disponibile</h3>
            <p class="text-lg pb-3">
                I pronostici saranno aperti dal
                {{str($championSettableFrom->isoFormat('D MMMM YYYY \a\l\l\e H:mm'))->replaceMatches('/(?<=\s)[a-z]/', static fn($match) => ucfirst($match[0]), 1)}}
            </p>
            <x-partials.countdown.main bgColor="bg-yellow-500" date="{{$championSettableFrom}}"/>
        </div>
    </div>
</x-champion::shared.layout>
