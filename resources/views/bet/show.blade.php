<x-_bet-card :game="$game">
    <x-_game_bar :games="$games" :game="$game"/>
    <div class="w-full sm:w-3/5 alert shadow-lg flex justify-center items-center sm:mt-20">
        <div>
            <h3 class="font-bold text-center text-sm sm:text-lg pb-3">Modifica il pronostico entro <br class="sm:hidden">la data di inizio dell'Europeo</h3>
            <div class="w-full flex justify-center items-center">
                <x-partials.countdown.main date="{{$game->started_at}}"/>
            </div>
        </div>
    </div>
    <div class="overflow-auto w-full pt-10 sm:px-10">
        <table class="table">
            <thead>
                <tr class="border-base-300">
                    <th>Nome</th>
                    <th>Segno</th>
                    <th>Risultato {{__($game->home_team->name)}} - {{__($game->away_team->name)}}</th>
                    <th>Gol/NoGol {{__($game->home_team->name)}}</th>
                    <th>Gol/NoGol {{__($game->away_team->name)}}</th>
                    <th>Ultimo Update</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    @class([
                        'border-b-gray-300',
                        'sm:[&>*]:text-lg',
                    ])
                >
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
            </tbody>
        </table>
    </div>
        <div class="row-span-12 justify-center">
            <div class="col-6 flex justify-center my-4">
                <a href="{{route('bet.edit', ['bet'=> $userBet])}}" class="btn btn-warning text-base-100">
                    Modifica Pronostico
                </a>
            </div>
        </div>
</x-_bet-card>
