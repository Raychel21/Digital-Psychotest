<?php

namespace App\Filament\Developer\Resources\Users\Tables;

use App\Enums\UserRole;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Peran')
                    ->badge()
                    ->color(fn (UserRole $state): string => match ($state) {
                        UserRole::Developer => 'danger',
                        UserRole::Administrator => 'warning',
                        UserRole::Participant => 'success',
                    }),
                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('role')
                    ->label('Peran')
                    ->options(UserRole::class),
            ])
            ->emptyStateHeading('Belum ada pengguna')
            ->emptyStateDescription('Tambahkan pengguna baru untuk mulai mengelola platform.')
            ->checkIfRecordIsSelectableUsing(
                fn (User $record): bool => $record->getKey() !== Auth::id(),
            )
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->hidden(fn (User $record): bool => $record->getKey() === Auth::id()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
