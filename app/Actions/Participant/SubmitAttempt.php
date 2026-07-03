<?php

namespace App\Actions\Participant;

use App\Actions\Participant\Support\AnswerPayload;
use App\Actions\Participant\Support\VisibleQuestions;
use App\Enums\AttemptStatus;
use App\Models\Attempt;
use App\Models\Question;
use App\Models\TestResult;
use App\Services\Scoring\ResultGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Menutup attempt: validasi kelengkapan jawaban wajib (hanya soal yang tampil),
 * pangkas jawaban dari soal tersembunyi, tandai selesai, lalu hitung hasil.
 *
 * Attempt yang kehabisan waktu dikirim otomatis: validasi soal wajib dilewati
 * dan jawaban parsial dinilai apa adanya.
 */
class SubmitAttempt
{
    public function __construct(
        private readonly ResultGenerator $resultGenerator,
        private readonly VisibleQuestions $visibleQuestions,
    ) {}

    /**
     * @throws ValidationException jika attempt tidak berjalan atau masih ada soal wajib kosong.
     */
    public function handle(Attempt $attempt): TestResult
    {
        if ($attempt->status !== AttemptStatus::InProgress) {
            throw ValidationException::withMessages([
                'attempt' => 'Attempt ini sudah tidak berjalan sehingga tidak dapat dikirim.',
            ]);
        }

        $attempt->loadMissing(['assessment.questions.options', 'answers']);

        $visibleQuestions = $this->visibleQuestions->for($attempt);

        if (! $attempt->isExpired()) {
            $missing = $this->missingRequiredQuestionNumbers($attempt, $visibleQuestions);

            if ($missing !== []) {
                throw ValidationException::withMessages([
                    'attempt' => 'Masih ada soal wajib yang belum dijawab: nomor '.implode(', ', $missing).'.',
                ]);
            }
        }

        return DB::transaction(function () use ($attempt, $visibleQuestions): TestResult {
            $this->pruneHiddenAnswers($attempt, $visibleQuestions);

            $attempt->forceFill([
                'status' => AttemptStatus::Completed,
                'completed_at' => now(),
            ])->save();

            return $this->resultGenerator->generate($attempt);
        });
    }

    /**
     * Nomor urut (1-based, sesuai penomoran di runner) soal wajib yang tampil
     * namun belum memiliki jawaban lengkap dan valid.
     *
     * @param  Collection<int, Question>  $visibleQuestions
     * @return list<int>
     */
    private function missingRequiredQuestionNumbers(Attempt $attempt, Collection $visibleQuestions): array
    {
        $answers = $attempt->answers->keyBy('question_id');
        $missing = [];

        foreach ($visibleQuestions as $index => $question) {
            if (! $question->required) {
                continue;
            }

            if (! AnswerPayload::isComplete($question, $answers->get($question->id)?->payload)) {
                $missing[] = $index + 1;
            }
        }

        return $missing;
    }

    /**
     * Hapus jawaban milik soal yang kini tersembunyi agar cabang logika
     * yang tidak tampil tidak ikut memengaruhi skor.
     *
     * @param  Collection<int, Question>  $visibleQuestions
     */
    private function pruneHiddenAnswers(Attempt $attempt, Collection $visibleQuestions): void
    {
        $attempt->answers()
            ->whereNotIn('question_id', $visibleQuestions->pluck('id'))
            ->delete();

        $attempt->unsetRelation('answers');
    }
}
