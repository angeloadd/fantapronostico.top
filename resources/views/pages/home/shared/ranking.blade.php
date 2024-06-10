<x-home::shared.card title="Classifica" link="{{route('standing')}}" :linkText="__('Vai alla Classifica Completa')">
    <x-ranking::shared.table :$ranking :isHome="true"/>
</x-home::shared.card>
