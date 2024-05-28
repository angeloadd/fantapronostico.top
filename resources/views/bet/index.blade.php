<x-_bet-card :game="$game">
    <x-_game_bar :games="$games" :game="$game"/>
        <div class="overflow-x-auto w-full sm:px-10">
            <table class="table table-zebra">
                <!-- head -->
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Segno</th>
                        <th>Risultato {{$game->home_team->name}} vs {{$game->away_team->name}}</th>
                        <th>Gol/Nogol {{$game->home_team->name}}</th>
                        <th>Gol/Nogol {{$game->away_team->name}}</th>
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
                            <td>{{$userBet->user->name}}</td>
                            <td>{{$userBet->sign}}</td>
                            <td>{{$userBet->home_score}} - {{$userBet->away_score}}</td>
                            <td>{{\App\Models\Player::getScorer($userBet->home_scorer_id)}}</td>
                            <td>{{\App\Models\Player::getScorer($userBet->away_scorer_id)}}</td>
                            <td class="bg-base-200">
                       <span title="ore {{$updatedAtTime}} e {{$updatedAtMillis}} millisecondi">
                        {{$updatedAt}}
                       </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

</x-_bet-card>
