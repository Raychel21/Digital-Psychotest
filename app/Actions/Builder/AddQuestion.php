<?php

namespace App\Actions\Builder;

use App\Enums\QuestionType;
use App\Models\Assessment;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

/**
 * Tambah soal baru ke urutan paling bawah kanvas builder.
 */
class AddQuestion
{
    public function handle(Assessment $assessment, QuestionType $type): Question
    {
        return DB::transaction(function () use ($assessment, $type): Question {
            $question = $assessment->questions()->create([
                'type' => $type,
                'text' => '',
                'sort' => ((int) $assessment->questions()->max('sort')) + 1,
                'required' => true,
            ]);

            if ($type->usesOptions()) {
                $question->options()->create([
                    'label' => 'Opsi 1',
                    'sort' => 1,
                    'scores' => [],
                ]);
            }

            return $question->load('options');
        });
    }
}
