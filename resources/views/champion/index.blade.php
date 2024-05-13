<x-layouts.with-drawer>
    <x-_champion_card>
        <div class="card-body pt-0">
            <div class="w-full justify-center items-center px-0 px-md-3">
                <div class="row-span-12 justify-center">
                    <div class="col-12 col-lg-10">
                        <div class="w-full px-0 pe-md-4">
                            <ul class="list-group list-group-horizontal row-span-12 sm:hidden mb-2">
                                <li class="list-group-item col-12 title-font text-bold">
                                    Utente/Vincitore/Capocannoniere/Data Inserimento
                                </li>
                            </ul>
                            <ul class="list-group list-group-horizontal row-span-12 hidden d-sm-flex mb-2">
                                <li class="list-group-item col-span-3 title-font text-bold">Nome</li>
                                <li class="list-group-item col-span-3 title-font text-bold">Vincitore</li>
                                <li class="list-group-item col-span-3 title-font text-bold">
                                    Capocannoniere
                                </li>
                                <li class="list-group-item col-span-3 title-font text-bold">
                                    Inserito il
                                </li>
                            </ul>
                            @foreach($champion->sortByDesc('updated_at')->values() as $key => $bet)
                                <ul class="list-group list-group-horizontal row-span-12 sm:hidden">
                                    <li class="list-group-item col-12 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                                        <a class="text-decoration-none @if($key%2===0 || Auth::user()?->id === $bet->user->id) text-base-100 @else text-dark @endif"
                                           href="{{route('statistics', ['user' => $bet->user])}}">
                                            {{$bet->user->full_name}}
                                        </a>
                                        <br/>
                                        {{$bet->team->name}}<br/>
                                        {{$bet->player->name}}<br/>
                                        {{$bet->updated_at}}<br/>
                                    </li>
                                </ul>
                                <ul class="list-group list-group-horizontal row-span-12 hidden d-sm-flex">
                                    <li class="list-group-item col-span-3 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                                        <a class="text-decoration-none @if($key%2===0 || Auth::user()?->id === $bet->user->id) text-base-100 @else text-dark @endif"
                                           href="{{route('statistics', ['user' => $bet->user])}}">
                                            {{$bet->user->full_name}}
                                        </a>
                                    </li>
                                    <li class="list-group-item col-span-3 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">{{$bet->team->name}}</li>
                                    <li class="list-group-item col-span-3 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">{{$bet->player->name}}</li>
                                    <li class="list-group-item col-span-3 @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">{{$bet->updated_at}}</li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </x-_champion_card>
</x-layouts.with-drawer>
