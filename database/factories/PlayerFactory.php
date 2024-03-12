<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
final class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstNameMale;
        $lastName = $this->faker->lastName;
        $displayedName = ucfirst($firstName[0]) . '. ' . $lastName;

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'displayed_name' => $displayedName,
        ];
    }
}
