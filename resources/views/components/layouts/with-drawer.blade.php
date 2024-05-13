<x-layouts.app>
    <x-slot name="title">
        {{$title ?? null}}
    </x-slot>
    <x-partials.drawer.drawer>
        {{$slot}}
    </x-partials.drawer.drawer>
</x-layouts.app>
