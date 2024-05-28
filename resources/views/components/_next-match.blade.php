<div class="card-header shadow-lg bg-success text-base-100 mx-3 next-match-header-custom rounded-md border-success">
    <div class="w-full px-0 py-0">
        <div class="row-span-12 p-0 justify-around">
            <div
                class="col-span-5 md:order-1 flex flex-col jsutify-content-center items-center py-3">
                <p class="title-font text-2xl m-1">{{$nextGame->home->name}}</p>
                <img src="{{$nextGame->home->logo}}" class="img-fluid" width="120" height="80"
                     alt="{{$nextGame->home->name}}-Flag">
            </div>
            <div
                class="flex items-center justify-center display-5 fp2024-title py-3 mt-4 md:hidden">
                VS
            </div>
            <div
                class="col-span-5 order-md-3 flex flex-col jsutify-content-center items-center py-3">
                <p class="title-font text-2xl m-1">{{$nextGame->away->name}}</p>
                <img src="{{$nextGame->away->logo}}" class="img-fluid" width="120" height="80"
                     alt="{{$nextGame->away->name}}-Flag">
            </div>
            <div class="w-100 text-base-100 text-center my-3 text-xl">
                Prossimo Incontro
            </div>
        </div>
    </div>
</div>
<div class="card-body w-full justify-center items-center pb-2 pt-0">
    <div class="row-span-12">
        <div class="col-6 flex flex-col jsutify-content-center items-start pe-0">
            <p class="m-1 text-info">Si disputerà il</p>
            <p class="m-1 text-primary text-xl">
                {{$nextGame->started_at->format('d ')}}
                {{ucfirst($nextGame->started_at->monthName)}}
                {{$nextGame->started_at->format(' Y')}}
            </p>
            <p class="m-1 text-primary text-xl">
                ore {{$nextGame->started_at->format('H:i')}}
            </p>
        </div>
        <div class="col-6 flex flex-col justify-center aling-items-center">
            <p class="text-dark fp2024-title w-100 text-center">Pronostica</p>
            <a href="{{route('bet.create', ['game' => $nextGame])}}" role="button" class="btn w-50 mx-auto btn-outline-success">Vai</a>
        </div>
    </div>
</div>
