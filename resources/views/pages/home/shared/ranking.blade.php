<x-home::shared.card title="Classifica" link="{{route('standing')}}" :linkText="__('Vai alla Classifica Completa')">
    <div class="overflow-x-auto w-full">
        <table class="table table-zebra border-collapse w-full">
            <thead>
                <tr>
                    <th></th>
                    <th>Nome</th>
                    <th>Punti</th>
                    <th>Esatti</th>
                    <th>Segni</th>
                    <th>Gol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ranking as $position => $rank)
                    <tr
                        @class([
                            '[&>*]:bg-accent [&>*]:text-base-100' => Auth::user()?->id === $rank->user()->id,
                        ])
                    >
                        <th>
                            <span
                                @class([
                                    'badge badge-lg border-none badge-neutral text-base-100',
                                    'bg-amber-300' => $position === 0,
                                    'bg-gray-500' => $position === 1,
                                    'bg-amber-800' => $position === 2,
                                    'bg-secondary' => $position >= 3 && $position <= 5,
                                    'bg-accent' => $position === 7 || $position === 6,
                                ])
                            >{{$position+1 < 10 ? '0'.$position+1 : $position+1}}</span>
                        </th>
                        <td>
                            {{$rank->user()->name}}
                        </td>
                        <td>{{$rank->total()}}</td>
                        <td>{{$rank->results()}}</td>
                        <td>{{$rank->signs()}}</td>
                        <td>{{$rank->scorers()}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-home::shared.card>
