<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
final class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->country,
            'api_id' => $this->faker->randomNumber(),
            'code' => $this->faker->countryISOAlpha3,
            'logo' => $this->faker->imageUrl,
            'is_national' => $this->faker->boolean,
        ];
    }

    /**
     * @return Factory<Team>
     */
    public function national(): Factory
    {
        return $this->state(fn (): array => ['is_national' => true]);
    }

    /**
     * @return Factory<Team>
     */
    public function club(): Factory
    {
        return $this->state(fn (): array => ['is_national' => false]);
    }
}
