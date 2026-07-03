<?php

namespace App\Filament\Developer\Resources\Attempts\Tables;

use App\Enums\AttemptStatus;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AttemptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('assessment.name')
                    ->label('Alat Tes')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('completed_at')
                    ->label('Selesai')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('—'),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(AttemptStatus::class),
            ])
            ->emptyStateHeading('Belum ada pengerjaan tes')
            ->emptyStateDescription('Riwayat pengerjaan tes dari seluruh platform akan tampil di sini.');
    }
}
