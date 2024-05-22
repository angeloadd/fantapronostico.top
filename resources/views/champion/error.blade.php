<x-layout>
    <div class="container p-0 pb-0">
        <div class="row-span-12 justify-center mb-3 p-0">
            <div class="col-12">
                <div class="px-3 shadow-lg bg-warning text-base-100 mx-3 rounded-md border-warning">
                    <div class="w-full px-0 py-0">
                        <div class="row-span-12 p-0 justify-around">
                            <h2 class="text-center fs-1 pt-3 mb-0">
                                Il pronostico non è ancora disponibile
                            </h2>
                            <p class="text-center fs-1">Torna più tardi.</p>

                            <div class="w-100 text-base-100 text-center my-3 text-xl">
                                I pronostici saranno aperti dal
                                {{$championSettableFrom->format('d ')}}
                                {{ucfirst($championSettableFrom->monthName)}}
                                {{$championSettableFrom->format(' Y')}}
                                alle
                                {{$championSettableFrom->format('H:i')}}
                            </div>
                            <p class="flex items-center justify-center display-5 title-font py-3"
                               id="countDown" data-date="{{$championSettableFrom->format('Y-m-d H:i:s')}}"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
