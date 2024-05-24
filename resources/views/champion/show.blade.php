<x-_champion_card>
    <x-_message />
    <div role="alert" class="w-full sm:w-3/5 alert shadow-lg flex justify-center items-center sm:mt-20">
        <div>
            <h3 class="font-bold text-center text-sm sm:text-lg pb-3">Puoi modificare il pronostico fino all'inizio dell'Europeo</h3>
            <div class="w-full flex justify-center items-center">
                <x-partials.countdown.main date="{{$firstMatchDate}}"/>
            </div>
        </div>
    </div>
    <div class="overflow-auto w-full pt-10 sm:px-10">
        <table class="table">
            <thead>
                <tr class="border-base-300">
                    <th>Vincente</th>
                    <th>Capocannoniere</th>
                    <th>Ultimo Inserimento</th>
                </tr>
            </thead>
            <tbody>

                <tr
                    @class([
                        'border-b-gray-300',
                        'sm:[&>*]:text-lg',
                    ])
                >
                    <td>{{$champion->team->name}}</td>
                    <td>{{$champion->player->displayed_name}}</td>
                    <td class="bg-base-200">
                       <span title="ore {{$updatedAtTime}} e {{$updatedAtMillis}} millisecondi">
                        {{$updatedAt}}
                       </span>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row-span-12 justify-center">
            <div class="col-6 flex justify-center my-4">
                <a href="{{route('champion.edit', compact('champion'))}}" class="btn btn-warning text-base-100">
                    Modifica Pronostico
                </a>
            </div>
        </div>
    </div>
</x-_champion_card>
