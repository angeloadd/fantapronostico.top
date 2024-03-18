<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="og:title" content="Fantapronostico2022">
    <meta name="og:description" content="Gioco normale tra amici fidati, niente soldi, finanza pussa via!!!">
    <meta name="og:image" content="{{Vite::asset('resources/img/bannerworldcup.jpeg')}}">
    <meta name="og:url" content="https://fantaeuropeo2021.com">

    <title>{{ $title ?? 'Fantapronostico2022'}}</title>

    <!-- Styles -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    {{$style ?? ''}}
</head>
<body>
<button class="lg:hidden btn btn-neutral rounded-none btn-gear-custom" type="button" id="asideBtn">
    <img src="{{Vite::asset('resources/img/sidebar/bars.svg')}}" alt="sidebar burger button">
</button>
<div class="lg:flex">
    <div class="hidden lg:flex" id="sideBar">
        <x-_sidebar/>
    </div>
    <main class="container main-custom custom-scrollable">
        {{$slot}}
    </main>
</div>

<!-- Scripts -->
@stack('scripts')
</body>
</html>
