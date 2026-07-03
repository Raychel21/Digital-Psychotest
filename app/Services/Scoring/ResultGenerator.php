<?php

namespace App\Services\Scoring;

use App\Models\Attempt;
use App\Models\TestResult;
use App\Services\Logic\LogicEvaluator;

/**
 * Orkestrasi penilaian: raw score -> norma -> dimensi dominan -> interpretasi.
 */
class ResultGenerator
{
    public function __construct(
        private readonly RawScoreCalculator $calculator,
        private readonly NormConverter $converter,
        private readonly LogicEvaluator $logic,
    ) {}

    public function generate(Attempt $attempt): TestResult
    {
        $assessment = $attempt->assessment;

        $rawScores = $this->calculator->calculate($attempt);
        $normScores = $this->converter->convert($assessment, $rawScores);

        $primaryScale = $assessment->primaryScale();
        $primaryDimension = $this->highestDimension($normScores[$primaryScale] ?? []);

        return TestResult::updateOrCreate(
            ['attempt_id' => $attempt->id],
            [
                'raw_scores' => $rawScores,
                'norm_scores' => $normScores,
                'summary' => [
                    'primary_scale' => $primaryScale,
                    'primary_dimension' => $primaryDimension,
                    'interpretations' => $this->matchInterpretations($attempt, $normScores),
                    'variables' => $this->logic->evaluateVariables($assessment, $rawScores, $normScores),
                ],
            ],
        );
    }

    /**
     * @param  array<string, int>  $dimensionScores
     */
    private function highestDimension(array $dimensionScores): ?string
    {
        if ($dimensionScores === []) {
            return null;
        }

        return array_search(max($dimensionScores), $dimensionScores, true) ?: null;
    }

    /**
     * @param  array<string, array<string, int>>  $normScores
     * @return list<array{dimension: string, title: string, body: string}>
     */
    private function matchInterpretations(Attempt $attempt, array $normScores): array
    {
        $attempt->assessment->loadMissing('interpretations.dimension');
        $matched = [];

        foreach ($attempt->assessment->interpretations as $interpretation) {
            $code = $interpretation->dimension?->code;
            $value = $normScores[$interpretation->scale->value][$code] ?? null;

            if ($value !== null && $value >= $interpretation->min_value && $value <= $interpretation->max_value) {
                $matched[] = [
                    'dimension' => (string) $code,
                    'title' => $interpretation->title,
                    'body' => $interpretation->body,
                ];
            }
        }

        return $matched;
    }
}
