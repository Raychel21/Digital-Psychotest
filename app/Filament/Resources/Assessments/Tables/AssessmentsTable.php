<?php

namespace App\Filament\Resources\Assessments\Tables;

use App\Enums\AssessmentStatus;
use App\Filament\Resources\Assessments\AssessmentResource;
use App\Models\Assessment;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AssessmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('dimensions_count')
                    ->label('Dimensi')
                    ->counts('dimensions'),
                TextColumn::make('questions_count')
                    ->label('Soal')
                    ->counts('questions'),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(AssessmentStatus::class),
            ])
            ->recordActions([
                Action::make('builder')
                    ->label('Buka Builder')
                    ->icon('heroicon-o-squares-plus')
                    ->url(fn (Assessment $record): string => AssessmentResource::getUrl('builder', ['record' => $record])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
