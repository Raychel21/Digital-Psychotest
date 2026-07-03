<?php

namespace App\Filament\Participant\Pages;

use App\Actions\Participant\SubmitAttempt;
use App\Actions\Participant\Support\VisibleQuestions;
use App\Enums\AttemptStatus;
use App\Enums\QuestionType;
use App\Filament\Participant\Pages\Concerns\PersistsRunnerAnswers;
use App\Models\Attempt;
use App\Models\Option;
use App\Models\Question;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class TakeTest extends Page
{
    use PersistsRunnerAnswers;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'tes/{attempt}';

    protected string $view = 'filament.participant.pages.take-test';

    public Attempt $attempt;

    public int $index = 0;

    /** @var array{option_id: string|null, option_ids: list<string>, most_option_id: string|null, least_option_id: string|null, ordered_option_ids: list<string>, text: string} */
    public array $state = [];

    /** @var Collection<int, Question>|null */
    protected ?Collection $visibleQuestions = null;

    public function mount(Attempt $attempt): void
    {
        abort_unless($attempt->user_id === auth()->id(), 403);

        if ($attempt->status !== AttemptStatus::InProgress) {
            $this->redirect(MyResults::getUrl());

            return;
        }

        $this->attempt = $attempt;

        if ($attempt->isExpired()) {
            $this->finishExpiredAttempt();

            return;
        }

        $this->index = (int) min(max(0, $attempt->current_index), max(0, $this->visibleQuestions()->count() - 1));
        $this->loadState();
    }

    public function getTitle(): string|Htmlable
    {
        return $this->attempt->assessment->name;
    }

    /** @return array<string> */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    /**
     * Soal yang tampil untuk peserta, sudah difilter aturan visible_if.
     *
     * @return Collection<int, Question>
     */
    public function visibleQuestions(): Collection
    {
        return $this->visibleQuestions ??= app(VisibleQuestions::class)->for($this->attempt);
    }

    public function currentQuestion(): ?Question
    {
        return $this->visibleQuestions()->get($this->index);
    }

    public function answeredCount(): int
    {
        return $this->attempt->answers()
            ->whereIn('question_id', $this->visibleQuestions()->pluck('id'))
            ->count();
    }

    /**
     * Batas akhir pengerjaan sebagai epoch milidetik untuk countdown di klien.
     */
    public function expiresAtMs(): ?int
    {
        return $this->attempt->expiresAt()?->getTimestampMs();
    }

    public function questionPartial(Question $question): string
    {
        return match ($question->type) {
            QuestionType::SingleChoice, QuestionType::Likert => 'filament.participant.pages.partials.take-test-single',
            QuestionType::MultipleChoice => 'filament.participant.pages.partials.take-test-multiple',
            QuestionType::MostLeast => 'filament.participant.pages.partials.take-test-most-least',
            QuestionType::Ranking => 'filament.participant.pages.partials.take-test-ranking',
            QuestionType::Text => 'filament.participant.pages.partials.take-test-text',
        };
    }

    /**
     * Opsi soal ranking sesuai urutan jawaban tersimpan, atau urutan default.
     *
     * @return Collection<int, Option>
     */
    public function rankingOptions(Question $question): Collection
    {
        $orderedIds = array_map(intval(...), $this->state['ordered_option_ids'] ?? []);

        if ($orderedIds === []) {
            return $question->options->values();
        }

        return collect($orderedIds)
            ->map(fn (int $id): ?Option => $question->options->firstWhere('id', $id))
            ->filter()
            ->values();
    }

    public function submit(SubmitAttempt $submitAttempt): void
    {
        $this->persistCurrentAnswer();

        if ($this->attempt->status !== AttemptStatus::InProgress) {
            return;
        }

        try {
            $submitAttempt->handle($this->attempt);
        } catch (ValidationException $exception) {
            Notification::make()
                ->title('Jawaban belum dapat dikumpulkan')
                ->body($exception->getMessage())
                ->danger()
                ->send();

            return;
        }

        Notification::make()
            ->title('Jawaban berhasil dikumpulkan')
            ->success()
            ->send();

        $this->redirect(ViewResult::getUrl(['attempt' => $this->attempt]));
    }

    /**
     * Dipanggil klien saat countdown mencapai nol; server tetap memverifikasi.
     */
    public function forceSubmitExpired(): void
    {
        if ($this->attempt->status === AttemptStatus::InProgress && $this->attempt->isExpired()) {
            $this->finishExpiredAttempt();
        }
    }

    protected function finishExpiredAttempt(): void
    {
        try {
            app(SubmitAttempt::class)->handle($this->attempt);
        } catch (ValidationException) {
            $this->redirect(MyResults::getUrl());

            return;
        }

        Notification::make()
            ->title('Waktu habis — jawaban tersimpan otomatis dinilai.')
            ->warning()
            ->send();

        $this->redirect(ViewResult::getUrl(['attempt' => $this->attempt]));
    }
}
