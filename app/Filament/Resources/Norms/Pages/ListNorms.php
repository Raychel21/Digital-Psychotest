<?php

namespace App\Filament\Resources\Norms\Pages;

use App\Filament\Resources\Norms\NormResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNorms extends ListRecords
{
    protected static string $resource = NormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
