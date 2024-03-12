@php
    $get = $get ?? '/';
@endphp

<header>
    <a
        href="{{$get}}"
        class="aspect-square w-28 flex justify-center items-center bg-accent relative rounded-full">
        <x-partials.logo.svg/>
        <div class="absolute inset-0 bg-primary translate-x-2 rounded-full"></div>
        <div class="absolute inset-0 bg-primary -translate-x-2 rounded-full"></div>
        <div class="absolute inset-0 bg-base-100 z-1 rounded-full"></div>
    </a>
</header>
