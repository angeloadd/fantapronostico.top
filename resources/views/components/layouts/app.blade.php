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

        <title>{{ $title ?? config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=crimson-text:400i,600i|open-sans:600|roboto:400|inter:400,700" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        {{ $slot }}
        <div class="toast"></div>
        @stack('scripts')
    </body>
</html>
