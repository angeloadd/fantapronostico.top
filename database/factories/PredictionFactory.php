<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prediction>
 */
final class PredictionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $game = Game::all()->random();

        return [
            'home_score' => $this->faker->randomDigit(),
            'away_score' => $this->faker->randomDigit(),
            'sign' => $this->faker->randomElement(['1', 'x', '2']),
        ];
    }
}
