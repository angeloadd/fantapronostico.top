<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Exceptions\ClubAndNationalTeamsCannotBeTheSameException;
use App\Models\Exceptions\ClubTeamCannotBeNationalException;
use App\Models\Exceptions\NationalTeamCannotBeClubException;
use App\Modules\Auth\Database\Factory\PlayerFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Player
 *
 * @property int $id
 * @property string $displayed_name
 * @property string $first_name
 * @property string $last_name
 * @property int|null $club_id
 * @property int|null $national_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Team|null $club
 * @property-read Collection<int, Game> $games
 * @property-read int|null $games_count
 * @property-read Collection<int, GameGoal> $goals
 * @property-read int|null $goals_count
 * @property-read Team|null $national
 * @property-read Collection<int, Tournament> $tournaments
 * @property-read int|null $tournaments_count
 *
 * @method static PlayerFactory factory($count = null, $state = [])
 * @method static Builder|Player newModelQuery()
 * @method static Builder|Player newQuery()
 * @method static Builder|Player query()
 * @method static Builder|Player whereClubId($value)
 * @method static Builder|Player whereCreatedAt($value)
 * @method static Builder|Player whereDisplayedName($value)
 * @method static Builder|Player whereFirstName($value)
 * @method static Builder|Player whereId($value)
 * @method static Builder|Player whereLastName($value)
 * @method static Builder|Player whereNationalId($value)
 * @method static Builder|Player whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
final class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'displayed_name',
        'first_name',
        'last_name',
        'national_id',
        'club_id',
    ];

    /**
     * @return BelongsTo<Team, Player>
     */
    public function national(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'national_id');
    }

    /**
     * @return BelongsTo<Team, Player>
     */
    public function club(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'club_id');
    }

    /**
     * @return BelongsToMany<Tournament>
     */
    public function tournaments(): BelongsToMany
    {
        return $this->belongsToMany(Tournament::class);
    }

    /**
     * @return HasMany<GameGoal>
     */
    public function goals(): HasMany
    {
        return $this->hasMany(GameGoal::class);
    }

    /**
     * @return BelongsToMany<Game>
     */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }

    protected static function booted(): void
    {
        self::saving(static function (Player $player): void {
            if ($player->club_id && $player->national_id && $player->club_id === $player->national_id) {
                throw ClubAndNationalTeamsCannotBeTheSameException::forPlayerId($player->id);
            }

            if ($player->club?->is_national) {
                throw ClubTeamCannotBeNationalException::forPlayerId($player->id);
            }

            // We have to check national exists before the flag to avoid that a null is casted to boolean
            if ($player->national && ! $player->national->is_national) {
                throw NationalTeamCannotBeClubException::forPlayerId($player->id);
            }
        });
    }
}
