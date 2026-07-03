<?php

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\Dimension;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dimension>
 */
class DimensionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assessment_id' => Assessment::factory(),
            'code' => strtoupper(fake()->unique()->lexify('???')),
            'name' => ucfirst(fake()->words(2, true)),
            'description' => fake()->sentence(),
            'sort' => 0,
        ];
    }
}
