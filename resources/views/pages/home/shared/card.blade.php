<div class="card w-full max-w-xl shadow-xl rounded-xl bg-gradient-to-br from-accent/40 via-accent/20 to-white  ">
    <div class="card-body">
        <div class="w-full flex justify-between">
            <h2 class="card-title pb-2">{{$title}}</h2>
            @if(! empty($link ?? null))
                <a
                        href="{{$link}}"
                        role="button"
                        class="link link-primary text-md sm:text-lg"
                >{{$linkText}}</a>
            @endif
        </div>
        {{$slot}}
    </div>
</div>
