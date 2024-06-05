<x-partials.fireworks.fireworks/>
<x-layouts.with-drawer>
    <div
        class="w-full flex flex-col items-center container-homepage-custom min-h-screen px-0">
        <div class="mb-5">
            <div class="flex justify-center items-center">
                <div class="w-full rounded-xl bg-base-100 border border-success text-success shadow-lg py-1 px-4">
                    <h1 class="my-1 text-center">Benvenuto {{Auth::user()->full_name ?? 'Guest'}}</h1>
                </div>
            </div>
        </div>

        <div class="w-full justify-center items-center px-2 pb-5 md:pt-5">
            <div
                class="mb-4 md:mb-0 flex justify-center items-center pe-0 home-page-position">
                <div class="flex justify-center items-center flex-col bg-secondary p-5 rounded-md">
                    <h3 class="text-2xl text-base-100">The Winner of fantapronostico2022 is</h3>
                    <h2 class="text-3xl fp2024-title text-base-100">{{$ranking[0] ?? null ? $ranking[0]->user()->name : 'Ciccio'}}</h2>
                    <img src="{{Vite::asset('resources/img/winner.webp')}}"
                         class="img-fluid"
                         alt="Flying man celebrates with hashtag winner"
                    >
                </div>
            </div>
        </div>
    </div>
</x-layouts.with-drawer>
