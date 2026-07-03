<?php

namespace App\Filament\Resources\Assessments\Support;

use App\Enums\QuestionType;

/**
 * Translates between the virtual scoring form fields and the Option `scores` json.
 *
 * `scores` shapes:
 * - choice/likert: array<string, int> — dimension code => points.
 * - most_least: array{most?: array<string, int>, least?: array<string, int>}.
 */
class OptionScoresMapper
{
    /**
     * @param  array<string, mixed>|null  $scores
     */
    public static function mostCode(?array $scores): ?string
    {
        return self::firstKey($scores['most'] ?? null);
    }

    /**
     * @param  array<string, mixed>|null  $scores
     */
    public static function leastCode(?array $scores): ?string
    {
        return self::firstKey($scores['least'] ?? null);
    }

    /**
     * Scores as a flat key-value map for choice/likert questions.
     *
     * @param  array<string, mixed>|null  $scores
     * @return array<string, int>
     */
    public static function keyValueScores(?array $scores): array
    {
        if ($scores === null || isset($scores['most']) || isset($scores['least'])) {
            return [];
        }

        return array_map(intval(...), $scores);
    }

    /**
     * Builds the `scores` json from repeater item data for the given question type.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function apply(array $data, mixed $type): array
    {
        $mostCode = $data['most_code'] ?? null;
        $leastCode = $data['least_code'] ?? null;
        unset($data['most_code'], $data['least_code']);

        if (self::resolveType($type) === QuestionType::MostLeast) {
            $scores = [];

            if (is_string($mostCode) && $mostCode !== '') {
                $scores['most'] = [$mostCode => 1];
            }

            if (is_string($leastCode) && $leastCode !== '') {
                $scores['least'] = [$leastCode => 1];
            }

            $data['scores'] = $scores;

            return $data;
        }

        $rawScores = is_array($data['scores'] ?? null) ? $data['scores'] : [];

        $data['scores'] = array_map(
            intval(...),
            array_filter($rawScores, fn (mixed $points): bool => $points !== null && $points !== ''),
        );

        return $data;
    }

    public static function resolveType(mixed $type): ?QuestionType
    {
        if ($type instanceof QuestionType) {
            return $type;
        }

        return is_string($type) && $type !== '' ? QuestionType::tryFrom($type) : null;
    }

    private static function firstKey(mixed $scores): ?string
    {
        return is_array($scores) && $scores !== [] ? (string) array_key_first($scores) : null;
    }
}
