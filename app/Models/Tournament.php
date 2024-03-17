<?php

declare(strict_types=1);

namespace App\Models;

use App\Modules\Auth\Database\Factory\TournamentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Tournament
 *
 * @property int $id
 * @property string $name
 * @property string $country
 * @property int $is_cup
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Game> $games
 * @property-read int|null $games_count
 * @property-read Collection<int, Player> $players
 * @property-read int|null $players_count
 * @property-read Collection<int, Team> $teams
 * @property-read int|null $teams_count
 *
 * @method static TournamentFactory factory($count = null, $state = [])
 * @method static Builder|Tournament newModelQuery()
 * @method static Builder|Tournament newQuery()
 * @method static Builder|Tournament query()
 * @method static Builder|Tournament whereCountry($value)
 * @method static Builder|Tournament whereCreatedAt($value)
 * @method static Builder|Tournament whereId($value)
 * @method static Builder|Tournament whereIsCup($value)
 * @method static Builder|Tournament whereName($value)
 * @method static Builder|Tournament whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
final class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'country',
        'is_cup',
    ];

    /**
     * @return BelongsToMany<Team>
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    /**
     * @return BelongsToMany<Player>
     */
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class);
    }

    /**
     * @return HasMany<Game>
     */
    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
}
