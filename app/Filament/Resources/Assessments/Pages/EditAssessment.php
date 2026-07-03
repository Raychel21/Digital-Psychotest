<?php

namespace App\Filament\Resources\Assessments\Pages;

use App\Filament\Resources\Assessments\AssessmentResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAssessment extends EditRecord
{
    protected static string $resource = AssessmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('builder')
                ->label('Buka Builder')
                ->icon('heroicon-o-squares-plus')
                ->url(fn (): string => AssessmentResource::getUrl('builder', ['record' => $this->getRecord()])),
            DeleteAction::make(),
        ];
    }
}
