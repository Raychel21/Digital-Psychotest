<?php

namespace App\Filament\Widgets;

use App\Enums\AssessmentStatus;
use App\Enums\AttemptStatus;
use App\Models\Assessment;
use App\Models\Attempt;
use App\Models\Invitation;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Ringkasan operasional untuk dasbor panel Admin: kondisi alat tes,
 * undangan yang masih bisa dibagikan, dan aktivitas pengerjaan.
 */
class AdminStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Alat Tes Terbit', Assessment::where('status', AssessmentStatus::Published)->count())
                ->description(Assessment::where('status', AssessmentStatus::Draft)->count().' masih draf')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('primary'),
            Stat::make('Undangan Tersedia', Invitation::whereNull('used_at')->count())
                ->description(Invitation::whereNotNull('used_at')->count().' sudah dipakai')
                ->icon('heroicon-o-ticket')
                ->color('warning'),
            Stat::make('Sedang Dikerjakan', Attempt::where('status', AttemptStatus::InProgress)->count())
                ->icon('heroicon-o-play')
                ->color('info'),
            Stat::make('Tes Selesai', Attempt::where('status', AttemptStatus::Completed)->count())
                ->icon('heroicon-o-clipboard-document-check')
                ->color('success'),
        ];
    }
}
