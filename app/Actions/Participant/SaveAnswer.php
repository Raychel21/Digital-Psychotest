<?php

namespace App\Actions\Participant;

use App\Actions\Participant\Support\AnswerPayload;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Question;
use Illuminate\Validation\ValidationException;

/**
 * Auto-save satu jawaban: simpan payload lengkap, atau hapus jika dikosongkan.
 * Menolak penulisan setelah batas waktu attempt habis (sumber kebenaran di server).
 */
class SaveAnswer
{
    /**
     * @param  array{option_id?: mixed, option_ids?: mixed, most_option_id?: mixed, least_option_id?: mixed, ordered_option_ids?: mixed, text?: mixed}  $state
     *
     * @throws ValidationException jika waktu habis, opsi tidak valid, atau most/least sama.
     */
    public function handle(Attempt $attempt, Question $question, array $state): void
    {
        if ($attempt->isExpired()) {
            throw ValidationException::withMessages([
                'attempt' => 'Waktu pengerjaan telah habis. Jawaban tidak dapat disimpan lagi.',
            ]);
        }

        $payload = AnswerPayload::fromState($question, $state);

        if ($payload === null) {
            Answer::query()
                ->where('attempt_id', $attempt->id)
                ->where('question_id', $question->id)
                ->delete();

            return;
        }

        Answer::query()->updateOrCreate(
            ['attempt_id' => $attempt->id, 'question_id' => $question->id],
            ['payload' => $payload],
        );
    }
}
