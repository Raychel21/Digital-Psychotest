<?php

namespace App\Filament\Resources\Norms;

use App\Filament\Resources\Norms\Pages\CreateNorm;
use App\Filament\Resources\Norms\Pages\EditNorm;
use App\Filament\Resources\Norms\Pages\ListNorms;
use App\Filament\Resources\Norms\Schemas\NormForm;
use App\Filament\Resources\Norms\Tables\NormsTable;
use App\Models\Norm;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NormResource extends Resource
{
    protected static ?string $model = Norm::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string|\UnitEnum|null $navigationGroup = 'Bank Soal';

    protected static ?string $navigationLabel = 'Norma Penilaian';

    protected static ?string $modelLabel = 'norma';

    protected static ?string $pluralModelLabel = 'norma penilaian';

    public static function form(Schema $schema): Schema
    {
        return NormForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NormsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNorms::route('/'),
            'create' => CreateNorm::route('/create'),
            'edit' => EditNorm::route('/{record}/edit'),
        ];
    }
}
