<x-layouts.with-drawer>
    <x-partials.notifications.toast-message/>
    <div class="w-full h-full flex flex-col items-center justify-start">
        <x-partials.header.header bgColor="bg-primary" text="Pronostico"/>
        {{$slot}}
    </div>
</x-layouts.with-drawer>