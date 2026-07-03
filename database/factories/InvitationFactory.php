<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Invitation>
 */
class InvitationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assessment_id' => Assessment::factory(),
            'code' => strtoupper(Str::random(10)),
            'user_id' => null,
            'expires_at' => null,
            'used_at' => null,
        ];
    }

    public function used(): static
    {
        return $this->state(fn (array $attributes): array => [
            'used_at' => now()->subMinute(),
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes): array => [
            'expires_at' => now()->subDay(),
        ]);
    }
}
