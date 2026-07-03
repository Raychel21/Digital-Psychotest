<?php

namespace App\Actions\Builder;

use App\Models\Option;
use App\Models\Question;

/**
 * Tambah opsi baru ke urutan paling bawah pada sebuah soal.
 */
class AddOption
{
    public function handle(Question $question): Option
    {
        $nextSort = ((int) $question->options()->max('sort')) + 1;

        return $question->options()->create([
            'label' => "Opsi {$nextSort}",
            'sort' => $nextSort,
            'scores' => [],
        ]);
    }
}
