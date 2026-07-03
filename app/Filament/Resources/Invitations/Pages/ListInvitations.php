<?php

namespace App\Filament\Resources\Invitations\Pages;

use App\Actions\GenerateInvitations;
use App\Filament\Resources\Invitations\InvitationResource;
use App\Models\Assessment;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Carbon;

class ListInvitations extends ListRecords
{
    protected static string $resource = InvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generateBatch')
                ->label('Buat Batch Kode')
                ->icon('heroicon-o-ticket')
                ->schema([
                    Select::make('assessment_id')
                        ->label('Alat Tes')
                        ->options(fn (): array => Assessment::query()->orderBy('name')->pluck('name', 'id')->all())
                        ->searchable()
                        ->required()
                        ->native(false),
                    TextInput::make('count')
                        ->label('Jumlah kode')
                        ->numeric()
                        ->integer()
                        ->minValue(1)
                        ->maxValue(500)
                        ->default(10)
                        ->required(),
                    DateTimePicker::make('expires_at')
                        ->label('Kedaluwarsa (opsional)')
                        ->native(false)
                        ->seconds(false),
                ])
                ->modalHeading('Buat batch kode undangan')
                ->modalDescription('Kode yang dibuat bisa langsung dibagikan ke peserta.')
                ->modalSubmitActionLabel('Buat Kode')
                ->action(function (array $data): void {
                    $assessment = Assessment::query()->findOrFail((int) $data['assessment_id']);

                    $invitations = app(GenerateInvitations::class)->handle(
                        $assessment,
                        (int) $data['count'],
                        filled($data['expires_at'] ?? null) ? Carbon::parse($data['expires_at']) : null,
                    );

                    Notification::make()
                        ->title("{$invitations->count()} kode undangan berhasil dibuat")
                        ->success()
                        ->send();
                }),
        ];
    }
}
