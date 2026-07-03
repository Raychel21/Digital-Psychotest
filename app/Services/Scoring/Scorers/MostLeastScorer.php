<?php

namespace App\Services\Scoring\Scorers;

use App\Enums\NormScale;
use App\Enums\QuestionType;
use App\Models\Question;
use App\Services\Scoring\Contracts\QuestionScorer;
use App\Services\Scoring\ScoreAccumulator;

/**
 * Menilai soal forced-choice (gaya DISC): satu opsi dipilih sebagai MOST,
 * satu sebagai LEAST. Skor opsi: {"most": {"D": 1}, "least": {"S": 1}}.
 */
class MostLeastScorer implements QuestionScorer
{
    public function supports(QuestionType $type): bool
    {
        return $type === QuestionType::MostLeast;
    }

    public function score(Question $question, array $payload, ScoreAccumulator $accumulator): void
    {
        $this->applySide($question, $payload, 'most_option_id', NormScale::Most, $accumulator);
        $this->applySide($question, $payload, 'least_option_id', NormScale::Least, $accumulator);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function applySide(
        Question $question,
        array $payload,
        string $payloadKey,
        NormScale $scale,
        ScoreAccumulator $accumulator,
    ): void {
        $optionId = $payload[$payloadKey] ?? null;

        if ($optionId === null) {
            return;
        }

        $option = $question->options->firstWhere('id', (int) $optionId);

        foreach ($option?->scores[$scale->value] ?? [] as $dimensionCode => $points) {
            if (is_int($points)) {
                $accumulator->add($scale->value, (string) $dimensionCode, $points);
            }
        }
    }
}
