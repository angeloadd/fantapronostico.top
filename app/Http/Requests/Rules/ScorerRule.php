<?php

declare(strict_types=1);

namespace App\Http\Requests\Rules;

use App\Models\Game;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

final class ScorerRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(now()->lte(Game::where('stage', 'group')->last()->started_at)){
            return;
        }

        if(empty($value)){
            $fail('ciao');
        }
    }
}
