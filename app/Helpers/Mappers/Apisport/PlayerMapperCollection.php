<?php

declare(strict_types=1);

namespace App\Helpers\Mappers\Apisport;

final class PlayerMapperCollection
{
    public function __construct(private array $playerMappers)
    {
    }

    public static function fromArray(array $response): self
    {
        return new self(self::mapResponse($response));
    }

    public function add(array $response): self
    {
        $this->playerMappers = [...$this->playerMappers, ...self::mapResponse($response)];

        return $this;
    }

    public function count(): int
    {
        return count($this->playerMappers);
    }

    public function toArray(): array
    {
        return $this->playerMappers;
    }

    private static function mapResponse(array $response): array
    {
        return array_map(
            static function (array $item): array {
                return [
                    'id' => $item['player']['id'],
                    'name' => $item['player']['name'],
                    'firstname' => $item['player']['firstname'],
                    'lastname' => $item['player']['lastname'],
                    'injured' => $item['player']['injured'],
                    'photo' => $item['player']['photo'],
                    'team_id' => $item['statistics'][0]['team']['id'],
                ];
            },
            $response
        );
    }
}
