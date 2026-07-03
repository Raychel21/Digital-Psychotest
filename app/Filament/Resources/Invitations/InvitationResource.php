<?php

namespace App\Filament\Resources\Invitations;

use App\Filament\Resources\Invitations\Pages\ListInvitations;
use App\Filament\Resources\Invitations\Tables\InvitationsTable;
use App\Models\Invitation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvitationResource extends Resource
{
    protected static ?string $model = Invitation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static string|\UnitEnum|null $navigationGroup = 'Pelaksanaan Tes';

    protected static ?string $navigationLabel = 'Undangan';

    protected static ?string $modelLabel = 'undangan';

    protected static ?string $pluralModelLabel = 'undangan';

    protected static ?string $recordTitleAttribute = 'code';

    public static function table(Table $table): Table
    {
        return InvitationsTable::configure($table);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvitations::route('/'),
        ];
    }
}
