<?php

namespace App\Filament\Resources\Assessments\Pages;

use App\Actions\Builder\AddOption;
use App\Actions\Builder\AddQuestion;
use App\Actions\Builder\DeleteOption;
use App\Actions\Builder\DeleteQuestion;
use App\Actions\Builder\DuplicateQuestion;
use App\Actions\Builder\ReorderOptions;
use App\Actions\Builder\ReorderQuestions;
use App\Actions\Builder\UpdateOption;
use App\Actions\Builder\UpdateQuestion;
use App\Enums\QuestionType;
use App\Filament\Resources\Assessments\AssessmentResource;
use App\Filament\Resources\Assessments\Pages\Concerns\HandlesBuilderImages;
use App\Filament\Resources\Assessments\Pages\Concerns\HandlesBuilderLogic;
use App\Models\Assessment;
use App\Models\Dimension;
use App\Models\Option;
use App\Models\Question;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Collection;
use Livewire\WithFileUploads;

class BuildAssessment extends Page
{
    use HandlesBuilderImages;
    use HandlesBuilderLogic;
    use InteractsWithRecord;
    use WithFileUploads;

    protected static string $resource = AssessmentResource::class;

    protected static ?string $breadcrumb = 'Builder';

    protected string $view = 'filament.admin.builder.build-assessment';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function getTitle(): string|Htmlable
    {
        return "Builder — {$this->getAssessment()->name}";
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    public function getAssessment(): Assessment
    {
        /** @var Assessment $assessment */
        $assessment = $this->getRecord();

        return $assessment;
    }

    /** @return Collection<int, Question> */
    public function questions(): Collection
    {
        return $this->getAssessment()->questions()->with('options')->get();
    }

    /** @return array<string, string> kode dimensi => label */
    public function dimensionOptions(): array
    {
        return $this->getAssessment()->dimensions
            ->mapWithKeys(fn (Dimension $dimension): array => [
                $dimension->code => "{$dimension->code} — {$dimension->name}",
            ])
            ->all();
    }

    public function addQuestion(string $type): void
    {
        app(AddQuestion::class)->handle($this->getAssessment(), QuestionType::from($type));
        $this->markSaved();
    }

    /** @param array<string, mixed> $data */
    public function updateQuestion(int $questionId, array $data): void
    {
        app(UpdateQuestion::class)->handle($this->question($questionId), $data);
        $this->markSaved();
    }

    public function duplicateQuestion(int $questionId): void
    {
        app(DuplicateQuestion::class)->handle($this->question($questionId));
        $this->markSaved();
    }

    public function deleteQuestion(int $questionId): void
    {
        app(DeleteQuestion::class)->handle($this->question($questionId));
        $this->markSaved();
    }

    /** @param list<int|string> $orderedIds */
    public function reorderQuestions(array $orderedIds): void
    {
        app(ReorderQuestions::class)->handle($this->getAssessment(), $orderedIds);
        $this->markSaved();
    }

    public function addOption(int $questionId): void
    {
        app(AddOption::class)->handle($this->question($questionId));
        $this->markSaved();
    }

    /** @param array<string, mixed> $data */
    public function updateOption(int $optionId, array $data): void
    {
        app(UpdateOption::class)->handle($this->option($optionId), $data);
        $this->markSaved();
    }

    public function deleteOption(int $optionId): void
    {
        app(DeleteOption::class)->handle($this->option($optionId));
        $this->markSaved();
    }

    /** @param list<int|string> $orderedIds */
    public function reorderOptions(int $questionId, array $orderedIds): void
    {
        app(ReorderOptions::class)->handle($this->question($questionId), $orderedIds);
        $this->markSaved();
    }

    protected function question(int $questionId): Question
    {
        return $this->getAssessment()->questions()->with('options')->findOrFail($questionId);
    }

    protected function option(int $optionId): Option
    {
        return Option::query()
            ->whereRelation('question', 'assessment_id', $this->getAssessment()->id)
            ->findOrFail($optionId);
    }

    protected function markSaved(): void
    {
        $this->dispatch('builder-saved');
    }
}
