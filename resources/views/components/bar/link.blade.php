@if($condition)
    <a
            @switch($side)
                @case('left') @keyup.left.window="window.location.assign('{{$link}}')" @break
                @case('right') @keyup.right.window="window.location.assign('{{$link}}')" @break
            @endswitch
            @class([
                'btn-primary btn rounded-full',
                'rounded-r-none' => $side === 'left',
                'rounded-l-none' => $side === 'right',
            ])
            href="{{$link}}"
    >
        <img width="18px" src="{{Vite::asset('resources/assets/images/'.$img)}}" alt="{{$alt}}">
    </a>
@endif
