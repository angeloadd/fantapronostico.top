<div
    x-transition
    x-init="setTimeout(() => $el.remove(), $el.firstElementChild.innerText.length * 100)"
    @class([
        'alert max-w-xs overflow-scroll md:max-w-xl md:flex md:justify-center',
        'bg-warning border-warning text-neutral' => $type === 'warning',
        'alert-error text-base-100' => $type === 'error',
        'alert-success text-base-100' => $type === 'success',
        'alert-info text-base-100' => $type === 'info',
    ])
>
    <span>{{__($text ?? "Success")}}</span>
</div>
