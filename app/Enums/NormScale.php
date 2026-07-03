<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum NormScale: string implements HasLabel
{
    case Sum = 'sum';
    case Most = 'most';
    case Least = 'least';
    case Change = 'change';

    public function getLabel(): string
    {
        return match ($this) {
            self::Sum => 'Sum (Total Poin)',
            self::Most => 'Most (Paling Sesuai)',
            self::Least => 'Least (Paling Tidak Sesuai)',
            self::Change => 'Change (Most − Least)',
        };
    }
}
