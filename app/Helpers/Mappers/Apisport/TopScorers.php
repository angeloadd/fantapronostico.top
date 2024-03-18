<?php

declare(strict_types=1);

namespace App\Helpers\Mappers\Apisport;

final class TopScorers
{
    public function __construct(private array $players)
    {
    }

    public static function fromArray(mixed $response): self
    {
        $previous = 0;
        $players = [];
        foreach ($response as $player) {
            if ($previous > $player['statistics'][0]['goals']['total']) {
                break;
            }
            $players[] = [
                'id' => $player['player']['id'],
            ];
            $previous = $player['statistics'][0]['goals']['total'];
        }

        return new self($players);
    }

    public function toArray(): array
    {
        return $this->players;
    }
}
