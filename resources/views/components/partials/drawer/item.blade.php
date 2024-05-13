<li class="w-full">
    <a href="{{route($routeName)}}"
        @class([
             'text-base-100 hover:bg-accent/80',
             'bg-accent' => Route::currentRouteName() === ($active ?? $routeName)
        ])
    >
        <img class="me-2"
             width="20px"
             src="{{Vite::asset('resources/assets/images/'.$svg.'.svg')}}"
             alt="dashboard"/>
        {{$text}}
    </a>
</li>
