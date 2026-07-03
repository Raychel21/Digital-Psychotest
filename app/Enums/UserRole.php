<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasLabel
{
    case Developer = 'developer';
    case Administrator = 'administrator';
    case Participant = 'participant';

    public function getLabel(): string
    {
        return match ($this) {
            self::Developer => 'Pengembang',
            self::Administrator => 'Administrator',
            self::Participant => 'Peserta',
        };
    }
}
