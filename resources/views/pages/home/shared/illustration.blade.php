<div class="w-full flex justify-around items-center">
    <img class="w-1/3" src="{{Vite::asset('resources/assets/images/'.$img)}}" alt="{{$alt}}">
    <span class="text-center lg:text-xl font-bold">
        {{$slot}}
    </span>
</div>
