<main class="flex items-center justify-center">
    <aside class="hidden lg:block lg:basis-3/5 overflow-hidden">
        <img
            class="object-cover object-center min-h-screen"
            src="{{Vite::asset('resources/assets/images/football_player.png')}}"
            alt="Draw of a football player cheering with a cup"
        >
    </aside>
    <section
            class="w-full flex flex-col justify-center items-center min-h-screen px-12 space-y-6 lg:basis-2/5"
    >
            <x-partials.logo.large />
        {{$slot}}
    </section>
</main>
