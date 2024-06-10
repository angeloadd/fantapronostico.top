<tr
    @class([
        '[&>*]:bg-accent [&>*]:text-base-100' => Auth::user()?->id === $rank->userId() && ($isHome ?? false),
        '[&>*]:bg-purple-500/90 [&>*]:text-base-100' => Auth::user()?->id === $rank->userId() && !($isHome ?? false),
        '[&>*]:text-lg text-center'
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
        {{$rank->userName()}}
    </td>
    <td>{{$rank->total()}}</td>
    <td>{{$rank->results()}}</td>
    <td>{{$rank->signs()}}</td>
    <td>{{$rank->scorers()}}</td>
</tr>
