<?php

namespace App\Actions\Builder;

use App\Models\Question;
use Illuminate\Support\Facades\DB;

/**
 * Persistenkan urutan opsi hasil drag & drop pada kartu soal.
 */
class ReorderOptions
{
    /**
     * @param  list<int|string>  $orderedIds  id opsi sesuai urutan baru
     */
    public function handle(Question $question, array $orderedIds): void
    {
        $orderedIds = array_values(array_map(intval(...), $orderedIds));

        DB::transaction(function () use ($question, $orderedIds): void {
            foreach ($orderedIds as $index => $id) {
                $question->options()->whereKey($id)->update(['sort' => $index + 1]);
            }
        });
    }
}
