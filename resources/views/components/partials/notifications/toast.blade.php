<div @click.away="$el.remove()" class="toast">
    <div class="alert text-base-100 max-w-xs overflow-scroll md:max-w-xl md:flex md:justify-center
        @switch($type ?? 'info')
            @case('warning') alert-warning
            @case('error') alert-error
            @case('success') alert-success
            @default alert-info
       @endswitch"
    >
        <span>{{$text ?? 'Task completed'}}</span>
    </div>
</div>
