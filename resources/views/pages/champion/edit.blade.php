<x-champion::shared.layout>
    <x-champion::shared.card>
        <x-champion::shared.card-header :$tournamentLogo :$tournamentName :$firstMatchDate text="Modifica"/>
        <x-champion::shared.form
            btnText="Modifica il Pronostico"
            btnBg="bg-warning"
            method="POST"
            action="{{route('champion.update', compact('champion'))}}"
            :$teams
            :$players
            :prediction="$champion"
        />
    </x-champion::shared.card>

</x-champion::shared.layout>
