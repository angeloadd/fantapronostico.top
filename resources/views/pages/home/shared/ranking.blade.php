<x-home::shared.card title="Classifica" link="{{route('standing')}}" :linkText="__('Vai alla Classifica Completa')">
    <div
        hx-get="{{route('rank')}}"
        hx-trigger="load"
        hx-swap="outerHTML"
        hx-target="this"
        hx-indicator="rank-load"
    >
    </div>
    <x-partials.notifications.loading id="rank-load"/>
</x-home::shared.card>
