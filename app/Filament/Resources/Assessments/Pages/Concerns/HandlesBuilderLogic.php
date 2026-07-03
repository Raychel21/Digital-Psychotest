<?php

namespace App\Filament\Resources\Assessments\Pages\Concerns;

use App\Actions\Builder\SaveAssessmentVariables;
use App\Actions\Builder\SaveQuestionLogic;
use App\Models\Question;
use Illuminate\Support\Str;

/**
 * Endpoint Livewire untuk editor logika Blockly (logika tampil & variabel).
 */
trait HandlesBuilderLogic
{
    /** @return array<string, mixed>|null */
    public function getQuestionLogic(int $questionId): ?array
    {
        return $this->question($questionId)->logic;
    }

    /** @param array<string, mixed>|null $workspace */
    public function saveQuestionLogic(int $questionId, mixed $rule = null, ?array $workspace = null): void
    {
        app(SaveQuestionLogic::class)->handle($this->question($questionId), $rule, $workspace);
        $this->markSaved();
    }

    /** @return list<array<string, mixed>> */
    public function getVariables(): array
    {
        return array_values($this->getAssessment()->logic['variables'] ?? []);
    }

    /** @param list<array<string, mixed>> $variables */
    public function saveVariables(array $variables): void
    {
        app(SaveAssessmentVariables::class)->handle($this->getAssessment(), $variables);
        $this->markSaved();
    }

    /**
     * Konteks segar untuk dropdown blok Blockly (daftar soal & dimensi).
     *
     * @return array{questions: list<array{id: string, label: string, type: string}>, dimensions: list<array{code: string, label: string}>}
     */
    public function getLogicContext(): array
    {
        $questions = $this->getAssessment()->questions()
            ->get(['id', 'text', 'sort', 'type'])
            ->map(fn (Question $question): array => [
                'id' => (string) $question->id,
                'label' => "Soal {$question->sort}: ".Str::limit(trim($question->text) !== '' ? $question->text : '(tanpa teks)', 40),
                'type' => $question->type->value,
            ])
            ->values()
            ->all();

        $dimensions = collect($this->dimensionOptions())
            ->map(fn (string $label, string $code): array => ['code' => $code, 'label' => $label])
            ->values()
            ->all();

        return ['questions' => $questions, 'dimensions' => $dimensions];
    }
}
