<?php

namespace App\Filament\Participant\Widgets;

use App\Enums\AttemptStatus;
use App\Models\Attempt;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class InProgressAttemptsWidget extends Widget
{
    protected string $view = 'filament.participant.widgets.in-progress-attempts-widget';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return static::query()->exists();
    }

    /**
     * @return array{attempts: Collection<int, Attempt>}
     */
    protected function getViewData(): array
    {
        return [
            'attempts' => static::query()
                ->with(['assessment' => fn ($query) => $query->withCount('questions')])
                ->withCount('answers')
                ->latest('started_at')
                ->get(),
        ];
    }

    /** @return Builder<Attempt> */
    protected static function query(): Builder
    {
        return Attempt::query()
            ->where('user_id', auth()->id())
            ->where('status', AttemptStatus::InProgress);
    }
}
