<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum QuestionType: string implements HasLabel
{
    case SingleChoice = 'single_choice';
    case MultipleChoice = 'multiple_choice';
    case Likert = 'likert';
    case MostLeast = 'most_least';
    case Ranking = 'ranking';
    case Text = 'text';

    public function getLabel(): string
    {
        return match ($this) {
            self::SingleChoice => 'Pilihan Tunggal',
            self::MultipleChoice => 'Pilihan Ganda',
            self::Likert => 'Skala Likert',
            self::MostLeast => 'Most / Least (Forced Choice)',
            self::Ranking => 'Urutkan (Ranking)',
            self::Text => 'Isian Teks (Tidak Dinilai)',
        };
    }

    public function isScored(): bool
    {
        return $this !== self::Text;
    }

    public function usesOptions(): bool
    {
        return $this !== self::Text;
    }
}
