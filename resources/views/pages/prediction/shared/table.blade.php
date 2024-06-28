<div class="w-full overflow-auto sm:overflow-visible">
    <table class="table table-zebra">
        <x-prediction::shared.table-head :$game/>
        <tbody>
            {{$slot}}
        </tbody>
    </table>
</div>
