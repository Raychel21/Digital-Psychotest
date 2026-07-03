<?php

namespace App\Filament\Developer\Widgets;

use App\Enums\AssessmentStatus;
use App\Enums\AttemptStatus;
use App\Enums\UserRole;
use App\Models\Assessment;
use App\Models\Attempt;
use App\Models\Invitation;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlatformStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $usersPerRole = User::query()
            ->selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role');

        $roleStats = array_map(
            fn (UserRole $role): Stat => Stat::make("Pengguna: {$role->getLabel()}", (int) ($usersPerRole[$role->value] ?? 0))
                ->icon('heroicon-o-users')
                ->color('primary'),
            UserRole::cases(),
        );

        return [
            ...$roleStats,
            Stat::make('Total Alat Tes', Assessment::count())
                ->icon('heroicon-o-clipboard-document-list')
                ->color('info'),
            Stat::make('Alat Tes Terbit', Assessment::where('status', AssessmentStatus::Published)->count())
                ->icon('heroicon-o-check-badge')
                ->color('success'),
            Stat::make('Tes Diselesaikan', Attempt::where('status', AttemptStatus::Completed)->count())
                ->icon('heroicon-o-clipboard-document-check')
                ->color('success'),
            Stat::make('Undangan Belum Dipakai', Invitation::whereNull('used_at')->count())
                ->icon('heroicon-o-envelope')
                ->color('warning'),
        ];
    }
}
