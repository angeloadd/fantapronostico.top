<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
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

    public function SetCreatedAtAttribute()
    {
        return $this->attributes['created_at'] = $this->attributes['updated_at'];
    }

    public function SetUpdatedAtAttribute($date)
    {
        return $this->attributes['updated_at'] = (new Carbon($date))->utc()->format('d-m-Y H:i:s.u');
    }

    public function getCreatedAtAttribute($date)
    {
        return $this->attributes['created_at'] = (new Carbon($date))->timezone('Europe/Rome');
    }

    public function getUpdatedAtAttribute($date)
    {
        return $this->attributes['updated_at'] = (new Carbon($date))->timezone('Europe/Rome');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Auth\Models\User::class);
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
