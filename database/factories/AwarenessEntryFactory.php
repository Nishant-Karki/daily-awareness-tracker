<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AwarenessEntry>
 */
class AwarenessEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'creative_hours' => $this->faker->randomFloat(2, 0, 10),
            'note' => $this->faker->sentence(),
        ];
    }
}
