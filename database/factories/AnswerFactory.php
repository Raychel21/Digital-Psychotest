<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attempt_id' => Attempt::factory(),
            'question_id' => Question::factory(),
            'payload' => ['text' => fake()->sentence()],
        ];
    }

    /**
     * Payload untuk single_choice/likert: {"option_id": 5}.
     */
    public function forOption(int $optionId): static
    {
        return $this->state(fn (array $attributes): array => [
            'payload' => ['option_id' => $optionId],
        ]);
    }

    /**
     * Payload untuk multiple_choice: {"option_ids": [1, 2]}.
     *
     * @param  list<int>  $optionIds
     */
    public function forOptions(array $optionIds): static
    {
        return $this->state(fn (array $attributes): array => [
            'payload' => ['option_ids' => $optionIds],
        ]);
    }

    /**
     * Payload untuk most_least: {"most_option_id": 1, "least_option_id": 3}.
     */
    public function mostLeast(int $mostOptionId, int $leastOptionId): static
    {
        return $this->state(fn (array $attributes): array => [
            'payload' => ['most_option_id' => $mostOptionId, 'least_option_id' => $leastOptionId],
        ]);
    }
}
