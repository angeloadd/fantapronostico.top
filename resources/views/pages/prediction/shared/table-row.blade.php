<tr
    @class([
        '[&>*]:bg-primary text-base-100' => Auth::user()?->id === $prediction->user->id && ($isIndex ?? false),
        '[&>*]:text-lg [&>*]:text-center'
    ])
>
    <td>
        <div class="tooltip tooltip-right" data-tip="{{$lastUpdate}}">#{{is_numeric($key) ? $key + 1 : null}}</div>
    </td>
    <td>{{$prediction->user->name}}</td>
    <td>{{$prediction->sign}}</td>
    <td>{{$prediction->home_score}} - {{$prediction->away_score}}</td>
    @if(!$prediction->game->isGroupStage())
        <td>{{\App\Models\Player::getScorer($prediction->home_scorer_id)}}</td>
        <td>{{\App\Models\Player::getScorer($prediction->away_scorer_id)}}</td>
    @endif
</tr>
