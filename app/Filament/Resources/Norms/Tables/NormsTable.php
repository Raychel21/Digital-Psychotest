<?php

namespace App\Filament\Resources\Norms\Tables;

use App\Enums\NormScale;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NormsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dimension.assessment.name')
                    ->label('Alat Tes')
                    ->sortable(),
                TextColumn::make('dimension.code')
                    ->label('Dimensi')
                    ->badge()
                    ->sortable(),
                TextColumn::make('scale')
                    ->label('Skala')
                    ->badge(),
                TextColumn::make('raw_min')
                    ->label('Skor Min')
                    ->sortable(),
                TextColumn::make('raw_max')
                    ->label('Skor Maks')
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Nilai Norma')
                    ->sortable(),
            ])
            ->defaultSort('raw_min')
            ->filters([
                SelectFilter::make('scale')
                    ->label('Skala')
                    ->options(NormScale::class),
                SelectFilter::make('dimension_id')
                    ->label('Dimensi')
                    ->relationship('dimension', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->emptyStateHeading('Belum ada norma penilaian')
            ->emptyStateDescription('Tambahkan norma untuk mengubah skor mentah menjadi nilai berstandar.')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
