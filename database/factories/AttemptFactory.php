<?php

namespace Database\Factories;

use App\Enums\AttemptStatus;
use App\Models\Assessment;
use App\Models\Attempt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attempt>
 */
class AttemptFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assessment_id' => Assessment::factory(),
            'user_id' => User::factory(),
            'invitation_id' => null,
            'status' => AttemptStatus::InProgress,
            'current_index' => 0,
            'started_at' => now(),
            'completed_at' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => AttemptStatus::Completed,
            'completed_at' => now(),
        ]);
    }

    public function abandoned(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => AttemptStatus::Abandoned,
        ]);
    }
}
