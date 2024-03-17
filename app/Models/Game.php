<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\GameFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Game
 *
 * @property int $id
 * @property int $tournament_id
 * @property string $started_at
 * @property string $stage
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Team|null $away_team
 * @property-read Team|null $home_team
 * @property-read Collection<int, Player> $players
 * @property-read int|null $players_count
 * @property-read Collection<int, Team> $teams
 * @property-read int|null $teams_count
 * @property-read Tournament $tournament
 *
 * @method static GameFactory factory($count = null, $state = [])
 * @method static Builder|Game newModelQuery()
 * @method static Builder|Game newQuery()
 * @method static Builder|Game query()
 * @method static Builder|Game whereCreatedAt($value)
 * @method static Builder|Game whereGameStart($value)
 * @method static Builder|Game whereId($value)
 * @method static Builder|Game whereStage($value)
 * @method static Builder|Game whereStatus($value)
 * @method static Builder|Game whereTournamentId($value)
 * @method static Builder|Game whereUpdatedAt($value)
 * @method static Builder|Game whereStartedAt($value)
 *
 * @mixin Eloquent
 */
final class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'tournament_id',
        'stage',
        'status',
        'started_at',
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = ['home_team', 'away_team'];

    protected $casts = [
        'started_at' => 'datetime',
    ];

    /**
     * @return BelongsToMany<Player>
     */
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class);
    }

    /**
     * @return BelongsTo<Tournament, Game>
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * @return BelongsToMany<Team>
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)->withPivot('is_away');
    }

    /**
     * @return Attribute<Team, Team>
     */
    public function homeTeam(): Attribute
    {
        return Attribute::make(
            get: fn (): ?Team => $this->teams->filter(static fn (Team $team): bool => ! $team->pivot->is_away)->first()
        );
    }

    /**
     * @return Attribute<Team, Team>
     */
    public function awayTeam(): Attribute
    {
        return Attribute::make(
            get: fn (): ?Team => $this->teams->filter(static fn (Team $team): bool => (bool) $team->pivot->is_away)->first()
        );
    }
}
