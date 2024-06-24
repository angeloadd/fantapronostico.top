<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\ApiSportDto;
use App\Modules\ApiSport\Exceptions\ApiSportParsingException;
use App\Modules\ApiSport\Exceptions\NoMapperStrategyFoundException;
use App\Modules\ApiSport\Mapper\Strategy\MapperStrategyInterface;
use ErrorException;

final class ApiSportMapper implements MapperInterface
{
    /**
     * @var MapperStrategyInterface[]
     */
    private array $mapperStrategies;

    public function __construct(MapperStrategyInterface ...$mapperStrategies)
    {
        $this->mapperStrategies = $mapperStrategies;
    }

    /**
     * {@inheritdoc}
     */
    public function map(array $externalResponse): ApiSportDto
    {
        foreach ($this->mapperStrategies as $mapperStrategy) {
            if ($mapperStrategy->supports($externalResponse)) {
                try {

                    return $mapperStrategy->map($externalResponse);
                } catch (ErrorException $arrayParsingException) {
                    throw ApiSportParsingException::withCause($arrayParsingException);
                }
            }
        }

        throw NoMapperStrategyFoundException::create((string) ($externalResponse['get'] ?? null));
    }
}
