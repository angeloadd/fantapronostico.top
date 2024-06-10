<div class="overflow-auto sm:overflow-visible w-full">
    <table class="table table-zebra w-full">
        <x-ranking::shared.table-head/>
        <tbody>
            @foreach($ranking as $position => $rank)
                <x-ranking::shared.table-row :$rank :$position :$isHome/>
            @endforeach
        </tbody>
    </table>
</div>
