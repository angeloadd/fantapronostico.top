<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Console;

use App\Enums\GameStatus;
use App\Events\GameGoalsUpdated;
use App\Helpers\Mappers\Apisport\Winner;
use App\Models\Game;
use App\Models\Player;
use App\Modules\ApiSport\Client\ApiSportClientInterface;
use App\Modules\ApiSport\Request\GetGameEventsRequest;
use App\Modules\ApiSport\Request\GetGameStatusRequest;
use App\Modules\ApiSport\Request\GetTopScorersRequest;
use App\Modules\ApiSport\Service\ApiSportServiceInterface;
use App\Modules\League\Models\League;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;
use Throwable;

final class GetTopScorersCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'fp:topscorers:get';

    /**
     * @var string
     */
    protected $description = 'Get winner from api sport';

    public function handle(ApiSportServiceInterface $apiSportService, LoggerInterface $logger): int
    {
        $league = League::first();

        if (null === $league) {
            $logger->error('No league found');

            return 1;
        }

        $dto = $apiSportService->getTopScorers(new GetTopScorersRequest($league->tournament->api_id, $league->tournament->season));

        Player::setTopScorers($dto, $league->tournament);

        return 0;
    }
}
