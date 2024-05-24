<x-layouts.app>
    <x-slot name="title">{{$title ?? ''}}</x-slot>
    <x-slot name="style">{{$style ?? ''}}</x-slot>
    <x-partials.drawer.drawer>
        {{$slot}}
    </x-partials.drawer.drawer>
</x-layouts.app>
