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

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{Vite::asset('resources/assets/favicon/apple-icon-57x57.png')}}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{Vite::asset('resources/assets/favicon/apple-icon-60x60.png')}}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{Vite::asset('resources/assets/favicon/apple-icon-72x72.png')}}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{Vite::asset('resources/assets/favicon/apple-icon-76x76.png')}}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{Vite::asset('resources/assets/favicon/apple-icon-114x114.png')}}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{Vite::asset('resources/assets/favicon/apple-icon-120x120.png')}}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{Vite::asset('resources/assets/favicon/apple-icon-144x144.png')}}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{Vite::asset('resources/assets/favicon/apple-icon-152x152.png')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{Vite::asset('resources/assets/favicon/apple-icon-180x180.png')}}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{Vite::asset('resources/assets/favicon/android-icon-192x192.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{Vite::asset('resources/assets/favicon/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{Vite::asset('resources/assets/favicon/favicon-96x96.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{Vite::asset('resources/assets/favicon/favicon-16x16.png')}}">
        <link rel="manifest" href="{{Vite::asset('resources/assets/favicon/manifest.json')}}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{Vite::asset('resources/assets/favicon/ms-icon-144x144.png')}}">
        <meta name="theme-color" content="#ffffff">

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
