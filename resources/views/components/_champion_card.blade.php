    <x-_message/>
    <div class="row-span-12 justify-center py-3 px-0">
        <div class="col-12">
            <div class="card shadow-lg">
                <div
                    class="card-header shadow-lg bg-primary text-base-100 mx-3 next-match-header-custom rounded-md border-primary">
                    <div class="w-full px-0 py-0">
                        <div class="row-span-12 p-0 justify-around">
                            <div
                                class="col-12 col-md-6 md:order-1 flex flex-col justify-center items-center py-3">
                                <p class="title-font text-2xl m-1">Squadra vincente</p>
                                <img src="{{Vite::asset('resources/img/coppaWorldCup.png')}}"
                                     class="img-fluid hidden d-md-inline" width="120" height="80" alt="">
                            </div>
                            <div
                                class="col-12 col-md-6 order-md-3 flex flex-col jsutify-content-center items-center py-3">
                                <p class="title-font text-2xl m-1">Capocannoniere</p>
                                <img src="{{Vite::asset('resources/img/golden_boot.svg')}}"
                                     class="img-fluid hidden d-md-inline" width="120" height="80" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                {{$slot}}
            </div>
        </div>
    </div>
