<x-prediction::shared.layout>
    <x-_game_bar :games="$games" :game="$game"/>
    <x-prediction::shared.table :$game>
        @foreach($sortedBets as $key => $prediction)
            <x-prediction::shared.table-row
                :prediction="$prediction"
                :lastUpdate="$prediction->updated_at->format('d/m/Y \o\r\e H:i:s \e u \m\s')"
                :key="$key"
                :isIndex="true"
            />
        @endforeach
    </x-prediction::shared.table>
</x-prediction::shared.layout>
