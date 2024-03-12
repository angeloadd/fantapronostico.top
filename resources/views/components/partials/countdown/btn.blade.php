<button
    hx-swap="outerHTML"
    hx-target="next div"
    hx-get="{{route('started_at')}}"
    class="btn btn-secondary"
    @click="$dispatch('clear-button')"
>
    Get Countdown
</button>
