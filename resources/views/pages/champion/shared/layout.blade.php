<x-layouts.with-drawer>
    <x-partials.notifications.toast-message/>
    <div class="size-full flex flex-col items-center justify-start">
        <x-partials.header.header bgColor="bg-secondary" text="Vincente e Capocannoniere"/>
        {{$slot}}
    </div>
</x-layouts.with-drawer>
