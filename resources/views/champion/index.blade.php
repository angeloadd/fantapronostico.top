<x-_champion_card>
    <x-partials.header.header text="Pronostico Vincente e Capocannoniere" bgColor="bg-secondary" />
    <div class="overflow-x-auto w-full sm:px-10">
        <table class="table table-zebra">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Vincitore</th>
                    <th>Capocannoniere</th>
                    <th>Inserito il</th>
                </tr>
            </thead>
            <tbody>
                @foreach($champion->sortByDesc('updated_at')->values() as $key => $bet)
                    <tr @class([
                        '[&>*]:bg-purple-500 text-base-100' => Auth::user()?->id === $bet->user->id,
                        'border-b-base-300',
                        'sm:[&>*]:text-lg'
                        ])>
                        <th>{{$key + 1}}</th>
                        <td>{{$bet->user->name}}</td>
                        <td>{{$bet->team->name}}</td>
                        <td>{{$bet->player->displayed_name}}</td>
                        <td>{{$bet->updated_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-_champion_card>
