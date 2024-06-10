<x-champion::shared.layout>
    <x-champion::shared.card>
        <x-champion::shared.card-header :$tournamentLogo :$tournamentName :$firstMatchDate text="Inserici"/>
        <x-champion::shared.form
            btnText="Pronostica"
            btnBg="bg-secondary"
            method="POST"
            action="{{route('champion.store')}}"
            :$teams
            :$players
        />
    </x-champion::shared.card>

</x-champion::shared.layout>
