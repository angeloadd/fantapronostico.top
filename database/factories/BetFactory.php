<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bet>
 */
final class BetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $array = Arr::flatten([1000000000, 1000000001, ...Player::all('id')->toArray()]);

        return [
            'home_result' => $this->faker->randomDigit(),
            'away_result' => $this->faker->randomDigit(),
            'sign' => $this->faker->randomElement(['1', 'X', '2']),
            'home_score' => $this->faker->randomElement($array),
            'away_score' => $this->faker->randomElement($array),
            'game_id' => 855736,
        ];
    }
}
