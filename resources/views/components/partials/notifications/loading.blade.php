<span id="{{$id}}" class="loading


    loading-dots
    @switch($size ?? 'sm')
        @case('md') loading-md
        @case('lg') loading-lg
        @case('xs') loading-xs
        @default loading-sm
    @endswitch
    htmx-indicator">
</span>
