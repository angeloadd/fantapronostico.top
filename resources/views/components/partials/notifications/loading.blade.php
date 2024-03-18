@php $size = $size ?? 'lg' @endphp
<span id="{{$id}}"
     @class([
        'loading loading-dots htmx-indicator',
        'loading-sm' => $size === 'sm',
        'loading-md' => $size === 'md',
        'loading-lg' => $size === 'lg',
        'loading-xs' => $size === 'xs',
     ])
></span>
