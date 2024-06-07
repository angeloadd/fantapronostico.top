<x-_bet-card>
    <div class="flex flex-col h-screen w-full justify-center items-center">
        <x-_game_bar :games="$games" :game="$game"/>
        <div class="overflow-x-auto w-full sm:px-10">
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Segno</th>
                        <th>Risultato {{__($game->home_team->name)}} vs {{__($game->away_team->name)}} ({{$game->home_score}} - {{$game->away_score}})</th>
                        @if(!$game->isGroupStage())
                        <th>Gol/Nogol {{__($game->home_team->name)}}</th>
                        <th>Gol/Nogol {{__($game->away_team->name)}}</th>
                        @endif
                        <th>Ultimo Update</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($sortedBets as $key => $bet)
                        <tr @class([
                        '[&>*]:bg-purple-500 text-base-100' => Auth::user()?->id === $bet->user->id,
                        'border-b-base-300',
                        'sm:[&>*]:text-lg'
                        ])>
                            <td>{{$bet->user->name}}</td>
                            <td>{{$bet->sign}}</td>
                            <td>{{$bet->home_score}} - {{$bet->away_score}}</td>
                            @if($this->isGroupStage())
                            <td>{{\App\Models\Player::getScorer($bet->home_scorer_id)}}</td>
                            <td>{{\App\Models\Player::getScorer($bet->away_scorer_id)}}</td>
                            @endif
                            <td class="bg-base-200">
                                <div class="tooltip" data-tip="ore {{$bet->updated_at->format('H:i:s')}} e {{$bet->updated_at->format('u')}} millisecondi">
                                    {{$bet->updated_at}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-_bet-card>
