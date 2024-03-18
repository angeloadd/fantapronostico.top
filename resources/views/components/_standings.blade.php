<div class="card-header mx-3 rounded-md standing-header-custom title-font bg-secondary text-base-100 text-4xl text-center">
    Classifica
</div>
<ul class="list-group list-group-flush">
    <li class="list-group-item">
        <div class="w-full p-0 justify-center">
            <div class="row-span-12 justify-around">
                <div class="col-1 title-font flex justify-around items-center text-xl">
                    #
                </div>
                <div class="col-span-3 title-font flex justify-around items-center text-xl">
                    Nome
                </div>
                <div class="col-2 title-font flex justify-around items-center text-xl">
                    Punti
                </div>
                <div class="col-2 title-font hidden d-sm-flex justify-around items-center text-xl">
                    Esatti
                </div>
                <div class="col-2 title-font hidden d-sm-flex justify-around items-center text-xl">
                    Segni
                </div>
                <div class="col-2 title-font hidden d-sm-flex justify-around items-center text-xl">
                    Gol
                </div>
            </div>
        </div>
    </li>

    @foreach($standing as $position => $player)
        @php
            //If guest and home show first ten positions
            //If Auth and home show first ten position plus or comprised of Auth user
            //If rank view show everything
            if(
                (!Auth::check() || Auth::user()->id !== $player->user()->id) &&
                (Route::currentRouteName() === '/' && !in_array($position, [0 ,1 ,2 ,3, 4, 5, 6, 7, 8 ,9], true))
            ){
                continue;
            }
        @endphp
        <li class="@if(Auth::user()?->id === $player->user()->id) bg-secondary text-base-100 @elseif($position%2===0) acc-bg text-base-100 @endif list-group-item">
            <div class="w-full p-0 justify-center ">
                <div class="row-span-12 justify-around">
                    <div class="col-1 flex justify-center items-center text-2xl">
                        @if($position +1 === 1)
                            <span class="badge rounded-pill first-place">{{$position+1}}</span>
                        @elseif($position+1 === 2)
                            <span class="badge rounded-pill second-place">{{$position+1}}</span>
                        @elseif($position+1 === 3)
                            <span class="badge rounded-pill third-place">{{$position+1}}</span>
                        @elseif(in_array(($position+1), [4, 5, 6], true))
                            <span class="badge rounded-pill bg-success">{{$position+1}}</span>
                        @elseif(in_array(($position+1), [7, 8], true))
                            <span class="badge rounded-pill main-bg">{{$position+1}}</span>
                        @elseif($position+1 === count($standing))
                            <span class="badge rounded-pill sec-bg">{{$position+1}}</span>
                        @else
                            <span class="rounded-pill badge @if($position%2!==0 && Auth::user()?->id !== $player->user()->id) main-text @endif">
                                {{$position+1}}
                            </span>
                        @endif
                    </div>
                    <div class="col-span-3 flex justify-center text-center items-center fs-6">
                        <a class="text-decoration-none @if($position%2===0 || Auth::user()?->id === $player->user()->id) text-base-100 @else text-dark @endif"
                           href="{{route('statistics', ['user' => $player->user()])}}">
                            {{$player->user()->full_name}}
                        </a>
                    </div>
                    <div class="col-2 flex justify-center items-center fs-6">
                        {{$player->total()}}
                    </div>
                    <div class="col-2 hidden d-sm-flex justify-center items-center fs-6">
                        {{$player->results()}}
                    </div>
                    <div class="col-2 hidden d-sm-flex justify-center items-center fs-6">
                        {{$player->signs()}}
                    </div>
                    <div class="col-2 hidden d-sm-flex justify-center items-center fs-6">
                        {{$player->scorers()}}
                    </div>
                </div>
            </div>
        </li>
    @endforeach
    @if(Route::currentRouteName() === '/')
        <li class="list-group-item">
            <div class="row-span-12 justify-around">
                <div class="col-6 flex justify-center items-center fs-6">
                    <a type="button" href="{{route('standing')}}" class="btn btn-secondary">
                        Vai alla classifica completa
                    </a>
                </div>
            </div>
        </li>
    @endif
</ul>
