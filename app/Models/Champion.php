<?php

declare(strict_types=1);

namespace App\Models;

use App\Modules\Auth\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Champion
 *
 * @property int $id
 * @property int $user_id
 * @property int $team_id
 * @property int $player_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder|Champion newModelQuery()
 * @method static Builder|Champion newQuery()
 * @method static Builder|Champion query()
 * @method static Builder|Champion whereCreatedAt($value)
 * @method static Builder|Champion whereId($value)
 * @method static Builder|Champion wherePlayerId($value)
 * @method static Builder|Champion whereTeamId($value)
 * @method static Builder|Champion whereUpdatedAt($value)
 * @method static Builder|Champion whereUserId($value)
 *
 * @property-read Player $player
 * @property-read Team $team
 * @property-read User $user
 *
 * @mixin Eloquent
 */
final class Champion extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'player_id', 'created_at', 'updated_at'];

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: static fn ($value) => (new Carbon($value))->timezone('Europe/Rome'),
            set: static fn ($value, $attributes) => $attributes['updated_at']
        );
    }

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: static fn ($value) => (new Carbon($value))->timezone('Europe/Rome'),
            set: static fn ($value) => (new Carbon($value))->timezone('Europe/Rome')->format('d-m-Y H:i:s.u')
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
