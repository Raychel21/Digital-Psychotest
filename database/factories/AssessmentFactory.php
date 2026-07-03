<?php

namespace Database\Factories;

use App\Enums\AssessmentStatus;
use App\Models\Assessment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Assessment>
 */
class AssessmentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'instructions' => fake()->paragraph(),
            'status' => AssessmentStatus::Draft,
            'settings' => null,
            'created_by' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => AssessmentStatus::Published,
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => AssessmentStatus::Archived,
        ]);
    }

    /**
     * Tentukan skala utama pada kolom settings (mis. "change" untuk DISC).
     */
    public function primaryScale(string $scale): static
    {
        return $this->state(fn (array $attributes): array => [
            'settings' => array_merge($attributes['settings'] ?? [], ['primary_scale' => $scale]),
        ]);
    }
}
