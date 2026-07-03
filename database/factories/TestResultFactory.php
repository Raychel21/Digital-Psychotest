<?php

namespace Database\Factories;

use App\Models\Attempt;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TestResult>
 */
class TestResultFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attempt_id' => Attempt::factory()->completed(),
            'raw_scores' => ['sum' => []],
            'norm_scores' => ['sum' => []],
            'summary' => null,
        ];
    }
}
