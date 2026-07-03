<?php

namespace App\Services\Scoring\Scorers;

use App\Enums\NormScale;
use App\Enums\QuestionType;
use App\Models\Question;
use App\Services\Scoring\Contracts\QuestionScorer;
use App\Services\Scoring\ScoreAccumulator;

/**
 * Menilai soal ranking (gaya RMIB): peserta mengurutkan seluruh opsi.
 * Payload: {"ordered_option_ids": [7, 3, 5]} — urutan pertama = peringkat 1.
 * Poin = peringkat (1-based) × poin dimensi pada opsi, diakumulasi ke skala "sum".
 * (RMIB: total peringkat rendah = minat tinggi; interpretasi diatur via norma.)
 */
class RankingScorer implements QuestionScorer
{
    public function supports(QuestionType $type): bool
    {
        return $type === QuestionType::Ranking;
    }

    public function score(Question $question, array $payload, ScoreAccumulator $accumulator): void
    {
        $orderedIds = array_map(intval(...), (array) ($payload['ordered_option_ids'] ?? []));

        foreach ($orderedIds as $index => $optionId) {
            $rank = $index + 1;
            $option = $question->options->firstWhere('id', $optionId);

            foreach ($option?->scores ?? [] as $dimensionCode => $points) {
                if (is_int($points)) {
                    $accumulator->add(NormScale::Sum->value, (string) $dimensionCode, $points * $rank);
                }
            }
        }
    }
}
