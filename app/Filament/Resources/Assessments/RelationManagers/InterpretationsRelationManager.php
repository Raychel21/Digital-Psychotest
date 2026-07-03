<?php

namespace App\Filament\Resources\Assessments\RelationManagers;

use App\Enums\NormScale;
use App\Models\Assessment;
use App\Models\Dimension;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InterpretationsRelationManager extends RelationManager
{
    protected static string $relationship = 'interpretations';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('dimension_id')
                    ->label('Dimension')
                    ->options(fn (): array => $this->dimensionOptions())
                    ->required()
                    ->searchable()
                    ->native(false),
                Select::make('scale')
                    ->options(NormScale::class)
                    ->required()
                    ->native(false),
                TextInput::make('min_value')
                    ->numeric()
                    ->integer()
                    ->required(),
                TextInput::make('max_value')
                    ->numeric()
                    ->integer()
                    ->required()
                    ->gte('min_value'),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('dimension.code')
                    ->badge()
                    ->sortable(),
                TextColumn::make('scale')
                    ->badge(),
                TextColumn::make('min_value')
                    ->sortable(),
                TextColumn::make('max_value')
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable()
                    ->limit(50),
            ])
            ->defaultSort('min_value')
            ->filters([
                SelectFilter::make('scale')
                    ->options(NormScale::class),
                SelectFilter::make('dimension_id')
                    ->label('Dimension')
                    ->options(fn (): array => $this->dimensionOptions()),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * @return array<int, string>
     */
    private function dimensionOptions(): array
    {
        /** @var Assessment $assessment */
        $assessment = $this->getOwnerRecord();

        return $assessment->dimensions
            ->mapWithKeys(fn (Dimension $dimension): array => [
                $dimension->id => "{$dimension->code} — {$dimension->name}",
            ])
            ->all();
    }
}
