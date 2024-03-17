<?php

declare(strict_types=1);

namespace App\Models;

use App\Modules\Auth\Database\Factory\TeamFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $logo
 * @property int $is_national
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Game> $games
 * @property-read int|null $games_count
 * @property-read Collection<int, Player> $players
 * @property-read int|null $players_count
 * @property-read Collection<int, Tournament> $tournaments
 * @property-read int|null $tournaments_count
 * @property-read object{is_away: bool} $pivot
 *
 * @method static TeamFactory factory($count = null, $state = [])
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @method static Builder|Team whereCode($value)
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereIsNational($value)
 * @method static Builder|Team whereLogo($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
final class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'code',
        'logo',
        'is_national',
    ];

    /**
     * @return HasMany<Player>
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, $this->is_national ? 'national_id' : 'club_id');
    }

    /**
     * @return BelongsToMany<Tournament>
     */
    public function tournaments(): BelongsToMany
    {
        return $this->belongsToMany(Tournament::class);
    }

    /**
     * @return BelongsToMany<Game>
     */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }
}
