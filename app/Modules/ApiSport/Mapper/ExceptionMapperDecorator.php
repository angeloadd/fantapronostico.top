<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Mapper;

use App\Modules\ApiSport\Dto\GamesDto;
use App\Modules\ApiSport\Dto\NationalDto;
use App\Modules\ApiSport\Dto\TeamsDto;
use App\Modules\ApiSport\Exceptions\ApiSportParsingException;
use ErrorException;
use Exception;
use Psr\Log\LoggerInterface;

final readonly class ExceptionMapperDecorator implements MapperInterface
{
    public function __construct(private MapperInterface $mapper, private LoggerInterface $logger)
    {

    }

    /**
     * @param array{
     *      parameters: array{
     *          league: int
     *      },
     *      response: list<array{
     *          team: array{
     *              id: int,
     *              name: string,
     *              code: string,
     *              logo: string,
     *              national: bool
     *          }
     *      }>
     *  } $externalResponse
     *
     * @throws ApiSportParsingException
     */
    public function mapTeamsResponse(array $externalResponse): TeamsDto
    {
        try {
            return $this->mapper->mapTeamsResponse($externalResponse);
        } catch (ErrorException $exception) {
            $this->logAndThrow($exception, $externalResponse);
        }
    }

    /**
     * @param array{
     *      parameters: array{
     *          league: int
     *      },
     *      response: list<array{
     *          fixture: array{
     *              id: int,
     *              timestamp: int,
     *              status: array{
     *                  short: string
     *              }
     *          },
     *          league: array{
     *              round: string
     *          },
     *          teams: array{
     *              home: array{
     *                  id: int
     *              },
     *              away: array{
     *                  id: int
     *              },
     *          }
     *      }>
     *  } $externalResponse
     *
     * @throws ApiSportParsingException
     */
    public function mapGamesResponse(array $externalResponse): GamesDto
    {
        try {
            return $this->mapper->mapGamesResponse($externalResponse);
        } catch (ErrorException $exception) {
            $this->logAndThrow($exception, $externalResponse);
        }
    }

    public function mapPlayersResponse(array $response): NationalDto
    {
        try {
            return $this->mapper->mapPlayersResponse($response);
        } catch (ErrorException $exception) {
            $this->logAndThrow($exception, $response);
        }
    }

    /**
     * @param  mixed[]  $externalResponse
     */
    private function logAndThrow(Exception|ErrorException $exception, array $externalResponse): never
    {
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
