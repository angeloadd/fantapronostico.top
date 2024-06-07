<div class="text-neutral/50 text-center">
    <p class="font-bold">
        {{str($date->isoFormat('D MMMM YYYY'))->title()}}
    </p>
    <p class="text-4xl">
        {{$date->format('H:i')}}
    </p>
</div>
