<?php

namespace App\Filament\Resources\Assessments\RelationManagers;

use App\Enums\QuestionType;
use App\Filament\Resources\Assessments\Support\OptionScoresMapper;
use App\Models\Assessment;
use App\Models\Dimension;
use App\Models\Option;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options(QuestionType::class)
                    ->required()
                    ->live()
                    ->native(false),
                TextInput::make('sort')
                    ->numeric()
                    ->integer()
                    ->default(0)
                    ->required(),
                Textarea::make('text')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('required')
                    ->default(true),
                $this->optionsRepeater(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('text')
            ->columns([
                TextColumn::make('sort')
                    ->sortable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('text')
                    ->limit(70)
                    ->searchable()
                    ->wrap(),
                IconColumn::make('required')
                    ->boolean(),
                TextColumn::make('options_count')
                    ->label('Opsi')
                    ->counts('options'),
            ])
            ->defaultSort('sort')
            ->filters([
                SelectFilter::make('type')
                    ->options(QuestionType::class),
            ])
            ->headerActions([
                CreateAction::make()->modalWidth('4xl'),
            ])
            ->recordActions([
                EditAction::make()->modalWidth('4xl'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private function optionsRepeater(): Repeater
    {
        return Repeater::make('options')
            ->relationship()
            ->schema([
                TextInput::make('label')
                    ->required()
                    ->maxLength(255),
                TextInput::make('sort')
                    ->numeric()
                    ->integer()
                    ->default(0)
                    ->required(),
                ...$this->scoreFields(),
            ])
            ->columns(2)
            ->collapsible()
            ->defaultItems(0)
            ->visible(fn (Get $get): bool => OptionScoresMapper::resolveType($get('type'))?->usesOptions() ?? false)
            ->mutateRelationshipDataBeforeCreateUsing(
                fn (array $data, Get $get): array => OptionScoresMapper::apply($data, $get('type')),
            )
            ->mutateRelationshipDataBeforeSaveUsing(
                fn (array $data, Get $get): array => OptionScoresMapper::apply($data, $get('type')),
            )
            ->columnSpanFull();
    }

    /**
     * Virtual scoring fields translated to/from the `scores` json by OptionScoresMapper.
     *
     * @return array<int, KeyValue|Select>
     */
    private function scoreFields(): array
    {
        return [
            Select::make('most_code')
                ->label('Dimensi saat dipilih Most')
                ->options(fn (): array => $this->dimensionOptions())
                ->native(false)
                ->visible(fn (Get $get): bool => $this->isMostLeast($get('../../type')))
                ->afterStateHydrated(function (Select $component, ?Option $record): void {
                    $component->state(OptionScoresMapper::mostCode($record?->scores));
                }),
            Select::make('least_code')
                ->label('Dimensi saat dipilih Least')
                ->options(fn (): array => $this->dimensionOptions())
                ->native(false)
                ->visible(fn (Get $get): bool => $this->isMostLeast($get('../../type')))
                ->afterStateHydrated(function (Select $component, ?Option $record): void {
                    $component->state(OptionScoresMapper::leastCode($record?->scores));
                }),
            KeyValue::make('scores')
                ->keyLabel('Kode dimensi')
                ->valueLabel('Poin')
                ->helperText(fn (): string => 'Kode dimensi tersedia: '.implode(', ', array_keys($this->dimensionOptions())))
                ->visible(fn (Get $get): bool => ! $this->isMostLeast($get('../../type')))
                ->afterStateHydrated(function (KeyValue $component, ?Option $record): void {
                    $component->state(OptionScoresMapper::keyValueScores($record?->scores));
                })
                ->columnSpanFull(),
        ];
    }

    /**
     * @return array<string, string>
     */
    private function dimensionOptions(): array
    {
        /** @var Assessment $assessment */
        $assessment = $this->getOwnerRecord();

        return $assessment->dimensions
            ->mapWithKeys(fn (Dimension $dimension): array => [
                $dimension->code => "{$dimension->code} — {$dimension->name}",
            ])
            ->all();
    }

    private function isMostLeast(mixed $type): bool
    {
        return OptionScoresMapper::resolveType($type) === QuestionType::MostLeast;
    }
}
