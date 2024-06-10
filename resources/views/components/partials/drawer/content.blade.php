<input class="drawer-toggle" type="checkbox" id="sidebarBtn"/>
<div class="drawer-content">
    <label for="sidebarBtn" aria-label="close sidebar" class="lg:hidden btn btn-neutral rounded-tl-lg rounded-bl-lg rounded-none fixed top-2 right-0 w-12 z-10 opacity-50">
        <img src="{{Vite::asset('resources/img/sidebar/bars.svg')}}" alt="sidebar burger button">
    </label>
    <div class="w-full flex justify-center items-center lg:overflow-y-auto lg:h-screen lg:max-h-screen">
        {{$slot}}
    </div>
</div>
