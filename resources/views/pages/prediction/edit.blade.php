<x-prediction::shared.layout>
    <div class="py-8">
        <x-prediction::shared.card>
            <x-prediction::shared.form
                method="PUT"
                action="{{route('prediction.update', ['prediction' => $prediction])}}"
                :homeTeamName="$game->home_team->name"
                :awayTeamName="$game->away_team->name"
                :homeTeamLogo="$game->home_team->logo"
                :awayTeamLogo="$game->away_team->logo"
                :$homeTeamPlayers
                :$awayTeamPlayers
                :startedAt="$game->started_at"
                :isGameInTheFuture="$game->started_at->isFuture()"
                :isGroupStage="$game->isGroupStage()"
                :btnText="__('Modifica il Pronostico')"
                btnBg="bg-secondary"
                :prediction="$prediction ?? null"
            />
        </x-prediction::shared.card>
    </div>
</x-prediction::shared.layout>
