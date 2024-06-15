<input class="drawer-toggle" type="checkbox" id="sidebarBtn"/>
<div class="drawer-content relative">
    <x-partials.drawer.navbar/>
    <div class="w-full flex justify-center items-center xl:overflow-y-auto xl:h-screen xl:max-h-screen">
        {{$slot}}
    </div>
</div>
