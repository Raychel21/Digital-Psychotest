<?php

namespace App\Filament\Resources\Attempts;

use App\Filament\Resources\Attempts\Pages\ListAttempts;
use App\Filament\Resources\Attempts\Pages\ViewAttempt;
use App\Filament\Resources\Attempts\Schemas\AttemptInfolist;
use App\Filament\Resources\Attempts\Tables\AttemptsTable;
use App\Models\Attempt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AttemptResource extends Resource
{
    protected static ?string $model = Attempt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Pelaksanaan Tes';

    protected static ?string $navigationLabel = 'Riwayat Pengerjaan';

    protected static ?string $modelLabel = 'pengerjaan';

    protected static ?string $pluralModelLabel = 'riwayat pengerjaan';

    public static function infolist(Schema $schema): Schema
    {
        return AttemptInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttemptsTable::configure($table);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttempts::route('/'),
            'view' => ViewAttempt::route('/{record}'),
        ];
    }
}
