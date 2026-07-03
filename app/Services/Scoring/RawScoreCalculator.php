<?php

namespace App\Services\Scoring;

use App\Enums\NormScale;
use App\Models\Attempt;
use App\Services\Scoring\Contracts\QuestionScorer;
use App\Services\Scoring\Scorers\ChoiceScorer;
use App\Services\Scoring\Scorers\MostLeastScorer;
use App\Services\Scoring\Scorers\RankingScorer;

class RawScoreCalculator
{
    /** @var list<QuestionScorer> */
    private readonly array $scorers;

    /**
     * @param  list<QuestionScorer>|null  $scorers
     */
    public function __construct(?array $scorers = null)
    {
        $this->scorers = $scorers ?? [new ChoiceScorer, new MostLeastScorer, new RankingScorer];
    }

    /**
     * Hitung skor mentah per skala dan dimensi dari seluruh jawaban attempt.
     *
     * @return array<string, array<string, int>>
     */
    public function calculate(Attempt $attempt): array
    {
        $attempt->loadMissing(['assessment.dimensions', 'answers.question.options']);

        $codes = $attempt->assessment->dimensions->pluck('code')->all();
        $accumulator = new ScoreAccumulator($codes);

        foreach ($attempt->answers as $answer) {
            $question = $answer->question;

            if ($question === null || ! $question->type->isScored()) {
                continue;
            }

            foreach ($this->scorers as $scorer) {
                if ($scorer->supports($question->type)) {
                    $scorer->score($question, $answer->payload ?? [], $accumulator);
                    break;
                }
            }
        }

        return $this->withChangeScale($accumulator, $codes);
    }

    /**
     * Skala "change" = most − least, hanya jika kedua skala tersebut ada.
     *
     * @param  list<string>  $codes
     * @return array<string, array<string, int>>
     */
    private function withChangeScale(ScoreAccumulator $accumulator, array $codes): array
    {
        $scores = $accumulator->toArray();

        if (isset($scores[NormScale::Most->value], $scores[NormScale::Least->value])) {
            foreach ($codes as $code) {
                $scores[NormScale::Change->value][$code] =
                    ($scores[NormScale::Most->value][$code] ?? 0)
                    - ($scores[NormScale::Least->value][$code] ?? 0);
            }
        }

        return $scores;
    }
}
