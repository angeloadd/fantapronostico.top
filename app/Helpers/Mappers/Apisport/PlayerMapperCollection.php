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
        if ([] === $response) {
            return [];
        }
        $players = $response['players'];
        $team = $response['team'];

        return array_map(
            static function (array $item) use ($team): array {
                $nameItems = explode(' ', $item['name']);
                $lastname = '';
                $firstname = '';
                foreach ($nameItems as $key => $nameItem) {
                    if ($key === (count($nameItems) - 1)) {
                        $lastname = $nameItem;

                        continue;
                    }

                    $firstname .= $nameItem . ' ';
                }

                return [
                    'id' => $item['id'],
                    'displayed_name' => $item['name'],
                    'first_name' => trim($firstname),
                    'last_name' => trim($lastname),
                    'national_id' => $team['id'],
                ];
            },
            $players
        );
    }
}
