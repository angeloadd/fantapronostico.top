<x-layout>
    <x-_champion_card>
        <div class="card-body pt-0">
            <div class="w-full justify-center items-center px-0 px-md-3">
                <div class="row-span-12 justify-center">
                    <div class="col-12">
                        <div class="w-full px-0 px-sm-5">
                            <ul class=" justify-center">
                                <li class=" col-4 title-font text-bold">Vincente</li>
                                <li class=" col-4 title-font text-bold">Capocannoniere</li>
                                <li class=" col-4 title-font text-bold">Ultimo Update</li>
                            </ul>
                            <ul class=" justify-center my-1">
                                <li class=" col-4 bg-primary text-base-100">{{$champion->team->name}}</li>
                                <li class=" col-4 bg-primary text-base-100">{{$champion->player->name}}</li>
                                <li class=" col-4 bg-primary text-base-100"
                                    title="ore {{(new Carbon\Carbon($champion->updated_at))->format('H:i:s')}} e {{(new Carbon\Carbon($champion->updated_at))->format('u')}} millisecondi">
                                    {{(new Carbon\Carbon($champion->updated_at))->format('d/m/Y - H:i:s')}}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row-span-12 justify-center">
                        <div class="col-6 flex justify-center my-4">
                            <a href="{{route('champion.edit', compact('champion'))}}" class="btn btn-danger text-base-100">
                                Modifica Pronostico
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-_champion_card>
</x-layout>
