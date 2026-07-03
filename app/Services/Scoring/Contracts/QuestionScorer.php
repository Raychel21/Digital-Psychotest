<?php

namespace App\Services\Scoring\Contracts;

use App\Enums\QuestionType;
use App\Models\Question;
use App\Services\Scoring\ScoreAccumulator;

interface QuestionScorer
{
    public function supports(QuestionType $type): bool;

    /**
     * @param  array<string, mixed>  $payload  Payload jawaban (lihat App\Models\Answer).
     */
    public function score(Question $question, array $payload, ScoreAccumulator $accumulator): void;
}
