<?php

namespace App\Filament\Resources\Norms\Schemas;

use App\Enums\NormScale;
use App\Models\Dimension;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class NormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Norma Penilaian')
                    ->description('Tentukan rentang skor mentah dan nilai norma yang sesuai.')
                    ->columns(2)
                    ->schema([
                        Select::make('dimension_id')
                            ->label('Dimensi')
                            ->relationship(
                                name: 'dimension',
                                modifyQueryUsing: fn (Builder $query): Builder => $query
                                    ->with('assessment')
                                    ->orderBy('assessment_id')
                                    ->orderBy('sort'),
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn (Dimension $record): string => "{$record->assessment->name} — {$record->code} ({$record->name})",
                            )
                            ->searchable(['code', 'name'])
                            ->preload()
                            ->required()
                            ->columnSpanFull(),
                        Select::make('scale')
                            ->label('Skala')
                            ->options(NormScale::class)
                            ->required()
                            ->native(false)
                            ->columnSpanFull(),
                        TextInput::make('raw_min')
                            ->label('Skor mentah min')
                            ->numeric()
                            ->integer()
                            ->required(),
                        TextInput::make('raw_max')
                            ->label('Skor mentah maks')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->gte('raw_min'),
                        TextInput::make('value')
                            ->label('Nilai norma')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->helperText('Nilai norma yang diberikan untuk rentang skor mentah ini.'),
                    ]),
            ]);
    }
}
