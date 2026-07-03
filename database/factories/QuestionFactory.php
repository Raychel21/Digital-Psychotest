<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\Assessment;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assessment_id' => Assessment::factory(),
            'type' => QuestionType::SingleChoice,
            'text' => fake()->sentence(),
            'sort' => 0,
            'required' => true,
            'settings' => null,
        ];
    }

    public function mostLeast(): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => QuestionType::MostLeast,
        ]);
    }

    public function multipleChoice(): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => QuestionType::MultipleChoice,
        ]);
    }

    public function likert(): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => QuestionType::Likert,
        ]);
    }

    public function text(): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => QuestionType::Text,
        ]);
    }
}
