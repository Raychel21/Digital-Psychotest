<?php

namespace Database\Factories;

use App\Enums\NormScale;
use App\Models\Dimension;
use App\Models\Norm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Norm>
 */
class NormFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rawMin = fake()->numberBetween(0, 10);

        return [
            'dimension_id' => Dimension::factory(),
            'scale' => NormScale::Sum,
            'raw_min' => $rawMin,
            'raw_max' => $rawMin + fake()->numberBetween(0, 5),
            'value' => fake()->numberBetween(-8, 8),
        ];
    }

    public function scale(NormScale $scale): static
    {
        return $this->state(fn (array $attributes): array => [
            'scale' => $scale,
        ]);
    }
}
