<?php

namespace App\Filament\Resources\Assessments\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DimensionsRelationManager extends RelationManager
{
    protected static string $relationship = 'dimensions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Kode singkat dimensi, dipakai pada skoring opsi (mis. D, I, S, C).'),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('sort')
                    ->numeric()
                    ->integer()
                    ->default(0)
                    ->required(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('sort')
                    ->sortable(),
                TextColumn::make('code')
                    ->badge()
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('description')
                    ->limit(60)
                    ->placeholder('—'),
            ])
            ->defaultSort('sort')
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
}
