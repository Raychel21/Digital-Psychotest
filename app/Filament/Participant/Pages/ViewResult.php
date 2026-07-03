<?php

namespace App\Filament\Participant\Pages;

use App\Enums\NormScale;
use App\Models\Attempt;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ViewResult extends Page
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $slug = 'hasil/{attempt}';

    protected string $view = 'filament.participant.pages.view-result';

    public Attempt $attempt;

    public function mount(Attempt $attempt): void
    {
        abort_unless($attempt->user_id === auth()->id(), 403);

        if (! $attempt->isCompleted() || $attempt->result === null) {
            $this->redirect(MyResults::getUrl());

            return;
        }

        $this->attempt = $attempt->load(['assessment.dimensions', 'result']);
    }

    public function getTitle(): string|Htmlable
    {
        return 'Hasil: '.$this->attempt->assessment->name;
    }

    /**
     * Nama dimensi per kode, untuk label tabel skor.
     *
     * @return array<string, string>
     */
    public function dimensionNames(): array
    {
        return $this->attempt->assessment->dimensions
            ->pluck('name', 'code')
            ->all();
    }

    public function scaleLabel(string $scale): string
    {
        return NormScale::tryFrom($scale)?->getLabel() ?? ucfirst($scale);
    }

    /**
     * Lebar bar (0-100) relatif terhadap nilai absolut tertinggi pada skala tersebut.
     *
     * @param  array<string, int|float>  $dimensionScores
     */
    public function barPercentage(array $dimensionScores, int|float $value): int
    {
        $max = max(array_map(abs(...), $dimensionScores) ?: [0]);

        if ($max <= 0) {
            return 0;
        }

        return (int) round(max(0, $value) / $max * 100);
    }
}
