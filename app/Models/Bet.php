<?php

declare(strict_types=1);

namespace App\Models;

use App\Helpers\ValueObject\ScoreMapper;
use App\Modules\Auth\Models\User;
use Database\Factories\BetFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Bet
 *
 * @property int $id
 * @property int|null $home_result
 * @property int|null $away_result
 * @property string|null $sign
 * @property string|null $home_score
 * @property string|null $away_score
 * @property int $user_id
 * @property int $game_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Game $game
 * @property-read User $user
 *
 * @method static BetFactory factory(...$parameters)
 * @method static Builder|Bet newModelQuery()
 * @method static Builder|Bet newQuery()
 * @method static Builder|Bet query()
 * @method static Builder|Bet whereAwayResult($value)
 * @method static Builder|Bet whereAwayScore($value)
 * @method static Builder|Bet whereCreatedAt($value)
 * @method static Builder|Bet whereGameId($value)
 * @method static Builder|Bet whereHomeResult($value)
 * @method static Builder|Bet whereHomeScore($value)
 * @method static Builder|Bet whereId($value)
 * @method static Builder|Bet whereSign($value)
 * @method static Builder|Bet whereUpdatedAt($value)
 * @method static Builder|Bet whereUserId($value)
 *
 * @property-read mixed $away_scorer_name
 * @property-read mixed $home_scorer_name
 *
 * @mixin Eloquent
 */
final class Bet extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_result',
        'away_result',
        'sign',
        'home_score',
        'away_score',
        'user_id',
        'game_id',
        'created_at',
        'updated_at',
    ];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    protected function awayScorerName(): Attribute
    {
        return Attribute::make(
            get: static fn ($value, $attribute) => ScoreMapper::mapToValue($attribute['away_score'])
        );
    }

    protected function homeScorerName(): Attribute
    {
        return Attribute::make(
            get: static fn ($value, $attribute) => ScoreMapper::mapToValue($attribute['home_score'])
        );
    }
}
