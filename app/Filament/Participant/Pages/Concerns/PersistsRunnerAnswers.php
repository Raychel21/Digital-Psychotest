<?php

namespace App\Filament\Participant\Pages\Concerns;

use App\Actions\Participant\SaveAnswer;
use App\Actions\Participant\Support\AnswerState;
use App\Models\Question;
use Illuminate\Validation\ValidationException;

/**
 * Navigasi antar soal + auto-save jawaban untuk runner tes peserta.
 * Semua operasi bekerja di atas daftar soal yang tampil (visible) saja.
 */
trait PersistsRunnerAnswers
{
    /**
     * Auto-save: setiap perubahan jawaban langsung dipersistenkan.
     */
    public function updatedState(mixed $value, string $key): void
    {
        $this->persistCurrentAnswer();
    }

    public function goToPrevious(): void
    {
        $this->step(-1);
    }

    public function goToNext(): void
    {
        $this->step(1);
    }

    /**
     * Pindah soal relatif terhadap posisi saat ini; delta dihitung setelah
     * persist karena visibilitas soal bisa berubah oleh jawaban barusan.
     */
    protected function step(int $delta): void
    {
        $this->persistCurrentAnswer();

        $target = $this->index + $delta;

        if ($target < 0 || $target >= $this->visibleQuestions()->count()) {
            return;
        }

        $this->index = $target;
        $this->attempt->update(['current_index' => $target]);
        $this->loadState();
    }

    protected function persistCurrentAnswer(): void
    {
        $question = $this->currentQuestion();

        if ($question === null) {
            return;
        }

        if ($this->attempt->isExpired()) {
            $this->finishExpiredAttempt();

            return;
        }

        $this->resetErrorBag();

        try {
            app(SaveAnswer::class)->handle($this->attempt, $question, $this->state);
        } catch (ValidationException $exception) {
            $this->setErrorBag($exception->errors());

            return;
        }

        $this->refreshVisibility($question);
    }

    /**
     * Hitung ulang soal yang tampil setelah jawaban berubah, sambil menjaga
     * posisi tetap pada soal yang sama bila masih tampil.
     */
    protected function refreshVisibility(Question $current): void
    {
        $this->attempt->unsetRelation('answers');
        $this->visibleQuestions = null;

        $newIndex = $this->visibleQuestions()->search(
            fn (Question $question): bool => $question->id === $current->id,
        );

        $this->index = $newIndex === false
            ? (int) min($this->index, max(0, $this->visibleQuestions()->count() - 1))
            : $newIndex;

        if ($this->currentQuestion()?->id !== $current->id) {
            $this->loadState();
        }
    }

    protected function loadState(): void
    {
        $question = $this->currentQuestion();

        $payload = $question === null ? null : $this->attempt->answers()
            ->where('question_id', $question->id)
            ->value('payload');

        $this->state = AnswerState::fromPayload($question, $payload);
    }
}
