<a
    href="{{route($name)}}"
    role="tab"
    class="tab fp2024-title text-lg
    @if(Route::currentRouteName() === $name)
        tab-active disabled cursor-pointer
   @endif"
>
    {{$text}}
</a>
