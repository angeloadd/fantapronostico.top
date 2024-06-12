<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Exceptions\ApiSportParsingException;
use ErrorException;
use Psr\Log\LoggerInterface;

final readonly class ExceptionMapperDecorator implements MapperInterface
{
    public function __construct(private MapperInterface $mapper, private LoggerInterface $logger)
    {

    }

    /**
     * @throws ApiSportParsingException
     */
    public function mapTeamsResponse(array $externalResponse): TeamsDto
    {
        try {
            return $this->mapper->mapTeamsResponse($externalResponse);
        } catch (ErrorException $exception) {
            $this->logger->error(
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
