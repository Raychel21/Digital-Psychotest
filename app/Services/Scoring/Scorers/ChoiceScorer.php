<?php

namespace App\Services\Scoring\Scorers;

use App\Enums\NormScale;
use App\Enums\QuestionType;
use App\Models\Question;
use App\Services\Scoring\Contracts\QuestionScorer;
use App\Services\Scoring\ScoreAccumulator;

/**
 * Menilai soal berbasis pilihan berpoin (single choice, multiple choice, Likert).
 * Skor opsi berupa map kode dimensi => poin, diakumulasi ke skala "sum".
 */
class ChoiceScorer implements QuestionScorer
{
    public function supports(QuestionType $type): bool
    {
        return in_array($type, [
            QuestionType::SingleChoice,
            QuestionType::MultipleChoice,
            QuestionType::Likert,
        ], true);
    }

    public function score(Question $question, array $payload, ScoreAccumulator $accumulator): void
    {
        foreach ($this->selectedOptionIds($payload) as $optionId) {
            $option = $question->options->firstWhere('id', $optionId);

            foreach ($option?->scores ?? [] as $dimensionCode => $points) {
                if (is_int($points)) {
                    $accumulator->add(NormScale::Sum->value, (string) $dimensionCode, $points);
                }
            }
        }
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return list<int>
     */
    private function selectedOptionIds(array $payload): array
    {
        if (isset($payload['option_id'])) {
            return [(int) $payload['option_id']];
        }

        return array_map(intval(...), (array) ($payload['option_ids'] ?? []));
    }
}
