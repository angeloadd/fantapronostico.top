<x-layouts.with-drawer>
    <x-_champion_card>
            <div class="w-full justify-center items-center px-0 px-md-3">
                <div class="justify-center">
                    <div class="w-full px-0 md:pr-4">
                        <ul class="sm:hidden mb-2">
                            <li class=" title-font text-bold">
                                Utente/Vincitore/Capocannoniere/Data Inserimento
                            </li>
                        </ul>
                        <ul class="hidden sm:flex mb-2">
                            <li class="title-font text-bold">Nome</li>
                            <li class="title-font text-bold">Vincitore</li>
                            <li class="title-font text-bold">
                                Capocannoniere
                            </li>
                            <li class="title-font text-bold">
                                Inserito il
                            </li>
                        </ul>
                        @foreach($champion->sortByDesc('updated_at')->values() as $key => $bet)
                            <ul class="sm:hidden">
                                <li class=" @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
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
                            <ul class="hidden sm:flex">
                                <li class=" @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">
                                    <a class="text-decoration-none @if($key%2===0 || Auth::user()?->id === $bet->user->id) text-base-100 @else text-dark @endif"
                                       href="{{route('statistics', ['user' => $bet->user])}}">
                                        {{$bet->user->name}}
                                    </a>
                                </li>
                                <li class=" @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">{{$bet->team->name}}</li>
                                <li class=" @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">{{$bet->player->name}}</li>
                                <li class=" @if(Auth::user()?->id === $bet->user->id) bg-secondary text-base-100 @elseif($key%2 === 0) bg-primary text-base-100 @else bg-white text-dark @endif">{{$bet->updated_at}}</li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
    </x-_champion_card>
</x-layouts.with-drawer>
