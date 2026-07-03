<?php

namespace App\Filament\Resources\Assessments\Schemas;

use App\Enums\AssessmentStatus;
use App\Enums\NormScale;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AssessmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Assessment')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state, string $operation): void {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug((string) $state));
                                }
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->alphaDash()
                            ->unique(ignoreRecord: true),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('instructions')
                            ->rows(5)
                            ->helperText('Instruksi yang ditampilkan kepada peserta sebelum mengerjakan.')
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options(AssessmentStatus::class)
                            ->default(AssessmentStatus::Draft)
                            ->required()
                            ->native(false),
                        Select::make('settings.primary_scale')
                            ->label('Primary scale')
                            ->options(NormScale::class)
                            ->default(NormScale::Sum->value)
                            ->helperText('Skala yang dipakai untuk menentukan dimensi dominan pada hasil.')
                            ->native(false),
                    ]),
            ]);
    }
}
