<tr
    @class([
        '[&>*]:bg-secondary [&>*]:text-base-100' => Auth::user()?->id === $champion->user->id && ($isIndex ?? false),
        '[&>*]:text-lg [&>*]:text-center'
    ])
>
    <th>
        <span class="tooltip tooltip-right font-normal" data-tip="{{$lastUpdate}}">#{{$key+1}}</span>
    </th>
    <td>
        {{$champion->user->name}}
    </td>
    <td>{{$champion->team->name}}</td>
    <td>{{$champion->player->displayed_name}} ({{$champion->player->national->name}})</td>
</tr>
