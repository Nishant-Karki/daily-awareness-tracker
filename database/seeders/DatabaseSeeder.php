<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AwarenessEntry;
use App\Models\QualityScore;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->count(10)->create();

        AwarenessEntry::factory()
            ->count(5)
            ->create(['user_id' => $user->id])
            ->each(function ($entry) use ($user) {
                QualityScore::factory()->create([
                    'awareness_entry_id' => $entry->id,
                    'user_id' => $user->id,
                ]);
            });

        AwarenessEntry::factory()
            ->count(15)
            ->create()
            ->each(function ($entry) {
                QualityScore::factory()->create([
                    'awareness_entry_id' => $entry->id,
                    'user_id' => $entry->user_id,
                ]);
            });
    }
}
