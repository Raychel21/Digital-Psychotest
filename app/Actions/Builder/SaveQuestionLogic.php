<?php

namespace App\Actions\Builder;

use App\Models\Question;

/**
 * Simpan aturan "logika tampil" hasil editor Blockly ke kolom `questions.logic`.
 *
 * Bentuk simpanan: {"visible_if": <jsonlogic>, "workspace": <blockly state>}.
 * LogicEvaluator hanya membaca `visible_if`; `workspace` dipakai untuk
 * merender ulang blok saat editor dibuka kembali. Workspace kosong = null.
 */
class SaveQuestionLogic
{
    /**
     * @param  array<string, mixed>|null  $workspace
     */
    public function handle(Question $question, mixed $rule, ?array $workspace): Question
    {
        $isEmptyWorkspace = $workspace === null || $workspace === [];

        if ($rule === null && $isEmptyWorkspace) {
            $question->update(['logic' => null]);

            return $question;
        }

        $question->update([
            'logic' => [
                'visible_if' => $rule,
                'workspace' => $workspace,
            ],
        ]);

        return $question;
    }
}
