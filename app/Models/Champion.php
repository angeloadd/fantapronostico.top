<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Champion
 *
 * @property int $id
 * @property int $user_id
 * @property int $team_id
 * @property int $player_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Champion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Champion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Champion query()
 * @method static \Illuminate\Database\Eloquent\Builder|Champion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Champion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Champion wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Champion whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Champion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Champion whereUserId($value)
 *
 * @mixin \Eloquent
 *
 * @property-read Player $player
 * @property-read Team $team
 * @property-read User $user
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
        return $this->attributes['updated_at'] = (new Carbon($date))->format('d-m-Y H:i:s.u');
    }

    public function getCreatedAtAttribute($date)
    {
        return $this->attributes['created_at'] = (new Carbon($date))->timezone('Europe/Rome')->format('d-m-Y H:i:s.u');
    }

    public function getUpdatedAtAttribute($date)
    {
        return $this->attributes['updated_at'] = (new Carbon($date))->timezone('Europe/Rome')->format('d-m-Y H:i:s.u');
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
