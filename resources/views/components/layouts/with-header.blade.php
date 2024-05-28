<x-layouts.with-drawer>
    <x-slot name="title">{{$title ?? ''}}</x-slot>
    <x-slot name="style">{{$style ?? ''}}</x-slot>
    <div class="w-full h-screen flex flex-col justify-between items-center">
        <x-partials.header.header
            :text="$text"
            :img="$img"
            :bgColor="$bgColor"
            :alt="$alt"
        />
        <div class="sm:overflow-auto overflow-x-auto w-full sm:h-full sm:flex flex-col justify-start items-center p-3">{{$slot}}</div>
    </div>
</x-layouts.with-drawer>
