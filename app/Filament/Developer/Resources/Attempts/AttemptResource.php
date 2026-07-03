<?php

namespace App\Filament\Developer\Resources\Attempts;

use App\Filament\Developer\Resources\Attempts\Pages\ListAttempts;
use App\Filament\Developer\Resources\Attempts\Tables\AttemptsTable;
use App\Models\Attempt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AttemptResource extends Resource
{
    protected static ?string $model = Attempt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Riwayat Pengerjaan';

    protected static ?string $modelLabel = 'pengerjaan';

    protected static ?string $pluralModelLabel = 'riwayat pengerjaan';

    public static function table(Table $table): Table
    {
        return AttemptsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'assessment']);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAttempts::route('/'),
        ];
    }
}
