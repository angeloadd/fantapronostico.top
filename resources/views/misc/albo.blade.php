<x-layout>
    <x-slot name="style">
        <style>
            body {
                margin: 0;
                padding: 0;
                background: $light;
                overflow: auto;
            }
        </style>
    </x-slot>

    <div class="pyro">
        <div class="before"></div>
        <div class="after"></div>
    </div>

        <div class="row-span-12 justify-center py-3 mt-5">
            <div class="col-12 col-lg-6">
                <div class="card shadow-lg">
                    <div
                        class="card-header shadow-lg bg-warning text-base-100 mx-3 next-match-header-custom rounded-md border-warning">
                        <div class="w-full px-0 py-0">
                            <div class="row-span-12 p-0 justify-around">
                                <div class="title-font fs-1 w-100 flex justify-center">Albo D'Oro</div>
                                <img src="{{Vite::asset('resources/img/albo.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="w-full justify-center items-center">
                            <div class="justify-center items-center row">
                                <div class="col-12 flex items-center flex-col justify-center">
                                    <p class="title-font fs-3">2013: Alessio Fuganti</p>
                                    <p class="title-font fs-3">2014: Luca Artesini</p>
                                    <p class="title-font fs-3">2016: Stefano Valente</p>
                                    <p class="title-font fs-3">2018: Giulio Delaini</p>
                                    <p class="title-font fs-3">2021: Matteo Caeran</p>
                                    <p class="title-font fs-3">2022: ???</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</x-layout>
