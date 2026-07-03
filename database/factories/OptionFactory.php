<?php

namespace Database\Factories;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Option>
 */
class OptionFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'label' => fake()->sentence(4),
            'sort' => 0,
            'scores' => [],
        ];
    }

    /**
     * Skor untuk soal berpoin (single/multiple/likert): {"D": 2}.
     *
     * @param  array<string, int>  $scores
     */
    public function withScores(array $scores): static
    {
        return $this->state(fn (array $attributes): array => [
            'scores' => $scores,
        ]);
    }

    /**
     * Skor untuk soal most/least: {"most": {"D": 1}, "least": {"S": 1}}.
     *
     * @param  array<string, int>  $most
     * @param  array<string, int>  $least
     */
    public function mostLeastScores(array $most, array $least): static
    {
        return $this->state(fn (array $attributes): array => [
            'scores' => ['most' => $most, 'least' => $least],
        ]);
    }
}
