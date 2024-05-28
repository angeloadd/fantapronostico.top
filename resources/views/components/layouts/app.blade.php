<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data
    x-bind:data-theme="$store.theme.mode"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">

        <title>{{isset($title) && $title?->isNotEmpty()? $title : config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=crimson-text:400i,600i|open-sans:700|roboto:400,700,900|inter:400,700" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
        @if(isset($style) &&$style?->isNotEmpty())
            {{ $style }}
        @endif
    </head>
    <body>
{{--        @if($isDeadlineForChampionBetPassed)--}}
{{--        here should go the notifications --}}
{{--            <div class="flex justify-center items-center">--}}
{{--                <a class="flex justify-center text-decoration-none text-3xl fp2024-title w-100 rounded-pill border border-1 bg-primary border-primary text-success shadow-lg py-3 px-4"--}}
{{--                   href="{{route('champion.create')}}">--}}
{{--                    <img class="img-fluid" width="25px" src="{{Vite::asset('resources/img/coppaWorldCup.png')}}"--}}
{{--                         alt="cup">--}}
{{--                    <span class="flex text-center justify-center items-center px-3">Vincente e Capocannoniere</span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        @endif--}}
        {{ $slot }}
        <div class="toast" x-ref="testWrapper"></div>
        @stack('scripts')
    </body>
</html>
