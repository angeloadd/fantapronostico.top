<li class="w-full">
    <a href="{{route($routeName)}}"
        @class([
             'text-base-100 hover:bg-neutral/30',
             'bg-neutral/50 hover:bg-neutral/50' => str_contains(Route::currentRouteName(), $active ?? $routeName)
        ])
    >
        <img class="me-2"
             width="20px"
             src="{{Vite::asset('resources/assets/images/'.$svg.'.svg')}}"
             alt="dashboard"/>
        {{$text}}
    </a>
</li>
