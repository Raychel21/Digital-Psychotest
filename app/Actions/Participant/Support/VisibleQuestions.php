<?php

namespace App\Actions\Participant\Support;

use App\Models\Attempt;
use App\Models\Question;
use App\Services\Logic\LogicEvaluator;
use Illuminate\Support\Collection;

/**
 * Menentukan soal yang tampil untuk sebuah attempt berdasarkan aturan
 * `questions.logic.visible_if`, dievaluasi terhadap jawaban tersimpan saat ini.
 */
class VisibleQuestions
{
    public function __construct(private readonly LogicEvaluator $logicEvaluator) {}

    /**
     * @return Collection<int, Question>
     */
    public function for(Attempt $attempt): Collection
    {
        $attempt->loadMissing('assessment.questions.options');

        $answerContext = $this->logicEvaluator->answerContext($attempt);

        return $attempt->assessment->questions
            ->filter(fn (Question $question): bool => $this->logicEvaluator->isQuestionVisible($question, $answerContext))
            ->values();
    }
}
