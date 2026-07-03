<?php

namespace Database\Factories;

use App\Enums\NormScale;
use App\Models\Dimension;
use App\Models\Interpretation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Interpretation>
 */
class InterpretationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dimension_id' => Dimension::factory(),
            'assessment_id' => fn (array $attributes): int => Dimension::query()
                ->findOrFail($attributes['dimension_id'])
                ->assessment_id,
            'scale' => NormScale::Sum,
            'min_value' => 0,
            'max_value' => 10,
            'title' => ucfirst(fake()->words(3, true)),
            'body' => fake()->paragraph(),
        ];
    }

    public function scale(NormScale $scale): static
    {
        return $this->state(fn (array $attributes): array => [
            'scale' => $scale,
        ]);
    }
}
