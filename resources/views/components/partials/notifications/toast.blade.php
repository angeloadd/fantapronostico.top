@php
$type ??= 'info';
@endphp

<div @click.away="$el.remove()" class="toast">
    <div class="alert alert-{{$type}} text-{{$type}}-content/40">
        <span>{{$text ?? 'Task completed'}}</span>
    </div>
</div>
