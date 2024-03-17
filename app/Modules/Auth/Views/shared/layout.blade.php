<x-layouts.app>
    <x-slot:title>{{$title ?? ''}}</x-slot>
    <main class="min-h-screen w-full flex items-center justify-center py-12 lg:py-0">
        <aside class="hidden max-h-screen overflow-hidden lg:block lg:basis-3/5">
            <img
                    class="object-cover object-center min-h-screen"
                    src="{{Vite::asset('resources/assets/images/football_player.png')}}"
                    alt="Draw of a football player cheering with a cup"
            >
        </aside>
        <section
                class="w-full flex flex-col items-center justify-center px-12 space-y-6 lg:basis-2/5"
        >
            <x-partials.logo.large />
            {{$slot}}
        </section>
    </main>
</x-layouts.app>
