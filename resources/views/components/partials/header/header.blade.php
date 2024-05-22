<div class="{{ $classes ?? '' }} {{ $bgColor }} sm:px-20 min-h-32 w-full flex justify-between items-end p-6 shadow-lg text-base-100 bg-gradient-to-b from-neutral/30 via-transparent">
    <h1 class="text-2xl sm:text-4xl font-bold scale-y-150 scale-x-75 uppercase tracking-wider">{{$text}}</h1>
    <img class="h-24 sm:h-32 {{$imgClasses ?? ''}}" src="{{Vite::asset('resources/assets/images/'.$img)}}" alt="{{$alt}}">
</div>
