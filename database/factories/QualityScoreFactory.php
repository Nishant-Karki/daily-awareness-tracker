<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\AwarenessEntry;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QualityScore>
 */
class QualityScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => AwarenessEntry::factory()->for(User::class),
            'awareness_entry_id' => AwarenessEntry::factory(),
            'score' => $this->faker->numberBetween(-2, 2),
        ];
    }
}
