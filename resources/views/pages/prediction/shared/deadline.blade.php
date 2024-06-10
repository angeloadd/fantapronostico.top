<div class="alert alert-warning shadow-lg flex flex-col justify-center items-center">
    <h3 class="font-bold text-center">
        Modifica il pronostico entro la data di inizio dell'incontro
    </h3>
    <div class="w-full flex justify-center items-center">
        <x-partials.countdown.main :date="$startedAt"/>
    </div>
</div>
