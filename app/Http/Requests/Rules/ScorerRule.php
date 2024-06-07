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
        $model = Game::where('stage', 'group')->orderBy('started_at', 'desc')->first();
        if (now()->lte($model?->started_at)) {
            return;
        }

        if (empty($value)) {
            $fail('ciao');
        }
    }
}
