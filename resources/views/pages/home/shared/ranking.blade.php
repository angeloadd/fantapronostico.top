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
                            '[&>*]:bg-primary/50' => Auth::user()?->id === $rank->user()->id,
                            '[&>*:first-child]:rounded-l-lg [&>*:last-child]:rounded-r-lg border-accent/0',
                        ])
                    >
                        <th>
                            <span
                                @class([
                                    'badge badge-lg border-none badge-accent',
                                    'first-place' => $position === 0,
                                    'text-base-100 second-place' => $position === 1,
                                    'text-base-100 third-place' => $position === 2,
                                    'text-base-100 bg-success' => $position >= 3 && $position <= 5,
                                    'text-base-100 bg-neutral' => $position === 7 || $position === 6,
                                ])
                            >{{$position+1}}</span>
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
