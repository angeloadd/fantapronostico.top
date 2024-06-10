<x-layouts.with-drawer>
    <div class="w-full h-screen flex flex-col justify-start items-center">
        <x-partials.header.header text="classifica" bgColor="bg-purple-500/90"/>
        <x-ranking::shared.table :$ranking :isHome="false" />
    </div>
</x-layouts.with-drawer>
