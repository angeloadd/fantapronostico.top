<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\ApiSportDto;
use App\Modules\ApiSport\Exceptions\ApiSportParsingException;
use App\Modules\ApiSport\Exceptions\NoMapperStrategyFoundException;

interface MapperInterface
{
    /**
     *  Throws ApiSportParsingException if array keys are not correct and the response does not follow the expected format.
     *  Throws NoStrategyFoundException if the mapper does not support the response with any strategy.
     *
     * @param  mixed[]  $externalResponse
     *
     * @throws NoMapperStrategyFoundException
     * @throws ApiSportParsingException
     */
    public function map(array $externalResponse): ApiSportDto;
}
