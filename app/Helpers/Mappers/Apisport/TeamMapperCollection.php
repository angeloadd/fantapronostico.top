<?php

declare(strict_types=1);

namespace App\Helpers\Mappers\Apisport;

final class TeamMapperCollection
{
    public const TEAM_NAME_MAPPER = [
        'Belgium' => 'Belgio',
        'France' => 'Francia',
        'Croatia' => 'Croazia',
        'Brazil' => 'Brasile',
        'Uruguay' => 'Uruguay',
        'Spain' => 'Spagna',
        'England' => 'Inghilterra',
        'Japan' => 'Giappone',
        'Senegal' => 'Senegal',
        'Serbia' => 'Serbia',
        'Switzerland' => 'Svizzera',
        'Mexico' => 'Messico',
        'South Korea' => 'Sud Corea',
        'Australia' => 'Australia',
        'Denmark' => 'Danimarca',
        'Iran' => 'Iran',
        'Saudi Arabia' => 'Arabia Saudita',
        'Poland' => 'Polonia',
        'Germany' => 'Germania',
        'Argentina' => 'Argentina',
        'Portugal' => 'Portogallo',
        'Tunisia' => 'Tunisia',
        'Costa Rica' => 'Costa Rica',
        'Morocco' => 'Marocco',
        'Wales' => 'Galles',
        'Netherlands' => 'Olanda',
        'Ghana' => 'Ghana',
        'Cameroon' => 'Camerun',
        'Qatar' => 'Qatar',
        'Ecuador' => 'Ecuador',
        'USA' => 'USA',
        'Canada' => 'Canada',
        'Italy' => 'Italia',
        'Hungary' => 'Ungheria',
        'Czech Republic' => 'Repubblica Ceca',
        'Ukraine' => 'Ucraina',
        'Slovakia' => 'Slovacchia',
        'Turkey' => 'Turchia',
        'Scotland' => 'Scozia',
    ];

    public function __construct(private array $teamMappers)
    {
    }

    public static function fromArray(array $response): self
    {
        return new self(
            array_map(
                static function (array $item): array {
                    return [
                        'id' => $item['team']['id'],
                        'name' => self::teamNameMapper($item['team']['name']),
                        'code' => $item['team']['code'],
                        'logo' => $item['team']['logo'],
                        'is_national' => true,
                    ];
                },
                $response
            )
        );
    }

    public static function teamNameMapper(string $name): string
    {
        return self::TEAM_NAME_MAPPER[$name] ?? $name;
    }

    public function toArray(): array
    {
        return $this->teamMappers;
    }
}
