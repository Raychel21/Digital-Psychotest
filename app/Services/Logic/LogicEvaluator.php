<?php

namespace App\Services\Logic;

use App\Models\Assessment;
use App\Models\Attempt;
use App\Models\Question;
use JWadhams\JsonLogic;

/**
 * Evaluasi aturan JsonLogic hasil editor blok (Blockly) secara server-side.
 *
 * Skema `questions.logic`:  {"visible_if": <jsonlogic>}
 * Skema `assessments.logic`: {"variables": [{"name": "x", "formula": <jsonlogic>}]}
 *
 * Konteks jawaban: {"answers": {"<questionId>": <payload>}} — payload sesuai
 * kontrak App\Models\Answer, mis. answers.12.option_id.
 * Konteks skor: {"raw": {...}, "norm": {...}} per skala & kode dimensi.
 */
class LogicEvaluator
{
    /**
     * Soal tampil bila tidak punya aturan, atau aturan visible_if bernilai truthy.
     *
     * @param  array<string, mixed>  $answerContext
     */
    public function isQuestionVisible(Question $question, array $answerContext): bool
    {
        $rule = $question->logic['visible_if'] ?? null;

        if ($rule === null) {
            return true;
        }

        return (bool) JsonLogic::apply($rule, $answerContext);
    }

    /**
     * @return array<string, mixed> {"answers": {"<id>": payload}}
     */
    public function answerContext(Attempt $attempt): array
    {
        $attempt->loadMissing('answers');

        $answers = [];

        foreach ($attempt->answers as $answer) {
            $answers[(string) $answer->question_id] = $answer->payload;
        }

        return ['answers' => $answers];
    }

    /**
     * Hitung variabel kustom assessment terhadap skor hasil.
     *
     * @param  array<string, array<string, int>>  $rawScores
     * @param  array<string, array<string, int>>  $normScores
     * @return array<string, mixed> nama variabel => nilai
     */
    public function evaluateVariables(Assessment $assessment, array $rawScores, array $normScores): array
    {
        $context = ['raw' => $rawScores, 'norm' => $normScores];
        $results = [];

        foreach ($assessment->logic['variables'] ?? [] as $variable) {
            $name = $variable['name'] ?? null;
            $formula = $variable['formula'] ?? null;

            if (is_string($name) && $name !== '' && $formula !== null) {
                $results[$name] = JsonLogic::apply($formula, [...$context, 'vars' => $results]);
            }
        }

        return $results;
    }
}
