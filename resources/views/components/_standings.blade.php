<div class="rounded-lg text-center fp2024-title text-2xl py-4 shadow-lg bg-purple-500 text-base-100 bg-gradient-to-t from-white/20 via-transparent to-white/20 transition duration-500 ease-in-out hover:-translate-y-4">
    Classifica
</div>
<div class="p-3">
    <div class="overflow-x-auto">
        <table class="table border-collapse">
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
                @foreach($standing as $position => $player)
                    @if((!Auth::check() || Auth::user()->id !== $player->user()->id) && (Route::currentRouteName() === 'home' && $position > 9))
                    @php
                        //If guest and home show first ten positions
                        //If Auth and home show first ten position plus or comprised of Auth user
                        //If rank view show everything
                        continue;
                    @endphp
                    @endif
                    <tr
                        @class([
                            '[&>*]:bg-purple-500 text-base-100' => Auth::user()?->id === $player->user()->id,
                            '[&>*]:bg-gray-500 text-base-100' => $position%2===0,
                            '[&>*:first-child]:rounded-l-lg',
                            '[&>*:last-child]:rounded-r-lg',
                        ])
                    >
                        <th>
                            <span
                                @class([
                                    'badge',
                                    'badge-lg',
                                    'border-none',
                                    'first-place' => $position === 0,
                                    'text-base-100 second-place' => $position === 1,
                                    'text-base-100 third-place' => $position === 2,
                                    'text-base-100 bg-success' => $position >= 3 && $position <= 5,
                                    'text-base-100 bg-neutral' => $position === 7 || $position === 6,
                                ])
                            >{{$position+1}}</span>
                        </th>
                        <td>
                            <a href="{{route('statistics', ['user' => $player->user()])}}">{{$player->user()->name}}</a>
                        </td>
                        <td>{{$player->total()}}</td>
                        <td>{{$player->results()}}</td>
                        <td>{{$player->signs()}}</td>
                        <td>{{$player->scorers()}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if(Route::currentRouteName() === 'home')
        <div class="flex justify-center items-center p-3">

            <a type="button" href="{{route('standing')}}" class="rounded-lg btn btn-secondary">
                Vai alla classifica completa
            </a>
        </div>
    @endif
</div>
