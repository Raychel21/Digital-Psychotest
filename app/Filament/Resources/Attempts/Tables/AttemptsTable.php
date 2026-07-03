<?php

namespace App\Filament\Resources\Attempts\Tables;

use App\Enums\AttemptStatus;
use Filament\Actions\ViewAction;
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
                    ->label('Peserta')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('assessment.name')
                    ->label('Alat Tes')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('answers_count')
                    ->label('Jawaban')
                    ->counts('answers'),
                TextColumn::make('started_at')
                    ->label('Dimulai')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->label('Selesai')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('—'),
            ])
            ->defaultSort('started_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(AttemptStatus::class),
                SelectFilter::make('assessment_id')
                    ->label('Alat Tes')
                    ->relationship('assessment', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->emptyStateHeading('Belum ada pengerjaan tes')
            ->emptyStateDescription('Riwayat pengerjaan tes peserta akan muncul di sini.')
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
