<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Exceptions\ApiSportParsingException;
use ErrorException;
use Illuminate\Support\Facades\Log;

final class ExceptionMapperDecorator implements MapperInterface
{
    public function __construct(private MapperInterface $mapper)
    {

    }

    public function mapTeamsResponse(array $externalResponse): TeamsDto
    {
        try {
            return $this->mapper->mapTeamsResponse($externalResponse);
        } catch (ErrorException $exception) {
            Log::error(
                $exception->getMessage(),
                [
                    'trace' => $exception->getTraceAsString(),
                    'response' => $externalResponse,
                ]
            );

            throw ApiSportParsingException::withCause($exception);
        }
    }
}
