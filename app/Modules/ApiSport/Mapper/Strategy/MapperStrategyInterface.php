<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper\Strategy;

use App\Modules\ApiSport\Dto\ApiSportDto;
use ErrorException;

interface MapperStrategyInterface
{
    /**
     * @param  mixed[]  $externalResponse
     */
    public function supports(array $externalResponse): bool;

    /**
     * @param  mixed[]  $externalResponse
     *
     * @throws ErrorException
     */
    public function map(array $externalResponse): ApiSportDto;
}
