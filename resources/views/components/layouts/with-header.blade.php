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
        <div class="overflow-auto w-full h-full flex flex-col justify-center sm:justify-start items-center">{{$slot}}</div>
    </div>
</x-layouts.with-drawer>
