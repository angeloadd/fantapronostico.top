<div class="{{ $bgColor }} sm:px-20 min-h-32 max-h-48 w-full flex justify-start items-center p-6 shadow-lg text-base-100 bg-gradient-to-b from-neutral/30 via-transparent">
    <h1 class="text-3xl sm:text-4xl font-bold uppercase">{{$text}}</h1>
    <img class="hidden sm:block h-full" src="{{Vite::asset('resources/assets/images/'.$img)}}" alt="{{$alt}}">
</div>
