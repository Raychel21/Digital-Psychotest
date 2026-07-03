<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AttemptStatus: string implements HasColor, HasLabel
{
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Abandoned = 'abandoned';

    public function getLabel(): string
    {
        return match ($this) {
            self::InProgress => 'Sedang Berjalan',
            self::Completed => 'Selesai',
            self::Abandoned => 'Ditinggalkan',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::InProgress => 'warning',
            self::Completed => 'success',
            self::Abandoned => 'gray',
        };
    }
}
