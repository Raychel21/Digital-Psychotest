<?php

namespace App\Filament\Resources\Norms\Pages;

use App\Filament\Resources\Norms\NormResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNorm extends EditRecord
{
    protected static string $resource = NormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
