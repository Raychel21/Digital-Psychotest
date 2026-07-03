<?php

namespace App\Filament\Resources\Invitations\Tables;

use App\Models\Invitation;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InvitationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),
                TextColumn::make('assessment.name')
                    ->label('Alat Tes')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->state(fn (Invitation $record): string => self::deriveStatus($record))
                    ->color(fn (string $state): string => match ($state) {
                        'Terpakai' => 'gray',
                        'Kedaluwarsa' => 'danger',
                        default => 'success',
                    }),
                TextColumn::make('user.name')
                    ->label('Dipakai oleh')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('expires_at')
                    ->label('Kedaluwarsa')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Tanpa kedaluwarsa'),
                TextColumn::make('used_at')
                    ->label('Dipakai pada')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('assessment_id')
                    ->label('Alat Tes')
                    ->relationship('assessment', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->emptyStateHeading('Belum ada undangan')
            ->emptyStateDescription('Buat batch kode undangan agar peserta bisa mulai mengerjakan tes.')
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function deriveStatus(Invitation $record): string
    {
        if ($record->used_at !== null) {
            return 'Terpakai';
        }

        if ($record->expires_at !== null && $record->expires_at->isPast()) {
            return 'Kedaluwarsa';
        }

        return 'Tersedia';
    }
}
