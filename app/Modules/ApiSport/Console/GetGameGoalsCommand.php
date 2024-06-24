<?php

declare(strict_types=1);

namespace App\Modules\ApiSport\Console;

use App\Enums\GameStatus;
use App\Helpers\Ranking\RankingCalculatorInterface;
use App\Models\Game;
use App\Modules\ApiSport\Request\GetGameEventsRequest;
use App\Modules\ApiSport\Request\GetGameStatusRequest;
use App\Modules\ApiSport\Service\ApiSportServiceInterface;
use App\Modules\League\Models\League;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;
use Throwable;

final class GetGameGoalsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'fp:games:goals:get';

    /**
     * @var string
     */
    protected $description = 'Get game goals from ApiSport';

    public function handle(ApiSportServiceInterface $apiSportService, LoggerInterface $logger): int
    {
        $league = League::first();
        if (null === $league) {
            $logger->error('No league found');

            return 1;
        }

        $games = Game::whereTournamentId($league->tournament->id)
            ->where('status', GameStatus::ONGOING)
            ->get();

        foreach ($games as $game) {
            try {

                $gameStatus = $apiSportService->getGameStatus(new GetGameStatusRequest($game->id));
                if (GameStatus::FINISHED !== $gameStatus->status) {
                    continue;
                }

                $response = $apiSportService->getGameGoals(new GetGameEventsRequest($game->id));

                $game->addGameGoals($response);

                $game->status = GameStatus::FINISHED;

                $game->save();

                $logger->info('Updated game goals: ' . $game->home_team . ' vs ' . $game->away_team);
                $this->info('Updated game goals: ' . $game->home_team . ' vs ' . $game->away_team);
            } catch (Throwable $e) {
                $logger->error('Error updating game goals: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
                $this->error('Error updating game goals: ' . $e->getMessage());

                continue;
            }
        }

        try {
            app(RankingCalculatorInterface::class)->calculate($league);
            $logger->info('Updated rankings: ' . $league->id);
            $this->info('Updated rankings: ' . $league->id);
        } catch (Throwable $e) {
            $logger->error('Error updating rankings: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $this->error('Error updating rankings: ' . $e->getMessage());
        }

        return 0;
    }
}
