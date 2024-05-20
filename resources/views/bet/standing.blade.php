<x-layouts.with-drawer>
    <div class="w-full h-screen overflow-y-scroll">
        <div class="bg-purple-500/90 sm:px-20 min-h-32 w-full flex justify-between items-end p-6 shadow-lg text-base-100 bg-gradient-to-b from-neutral/30 via-transparent">
            <h1 class="text-2xl sm:text-4xl font-bold">Classifica</h1>
            <img class="translate-y-3.5 h-32" src="{{Vite::asset('resources/assets/images/podium.svg')}}" alt="">
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr class="border-base-300 bg-purple-500/90 text-base-100">
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
                                '[&>*]:bg-purple-500/90 text-base-100 bg-gradient-to-b from-neutral/30' => Auth::user()?->id === $player->user()->id,
                                'border-b-base-300',
                                'sm:[&>*]:text-lg',
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
    </div>

</x-layouts.with-drawer>
