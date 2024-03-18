<a
    href="{{route($name)}}"
    role="tab"
    @class([
        'tab text-lg fp2024-title',
        'tab-active disabled cursor-pointer' => Route::currentRouteName() === $name
    ])
>
    {{$text}}
</a>
