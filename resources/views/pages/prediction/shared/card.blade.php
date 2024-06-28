<div class="card w-full @if($large ?? null) max-w-2xl @else max-w-xl @endif shadow-2xl rounded-xl bg-base-100 border-base-300">
    <div class="card-body p-2 sm:p-8">
        {{$slot}}
    </div>
</div>
