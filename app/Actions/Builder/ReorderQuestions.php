<?php

namespace App\Actions\Builder;

use App\Models\Assessment;
use Illuminate\Support\Facades\DB;

/**
 * Persistenkan urutan soal hasil drag & drop pada kanvas builder.
 */
class ReorderQuestions
{
    /**
     * @param  list<int|string>  $orderedIds  id soal sesuai urutan baru di kanvas
     */
    public function handle(Assessment $assessment, array $orderedIds): void
    {
        $orderedIds = array_values(array_map(intval(...), $orderedIds));

        DB::transaction(function () use ($assessment, $orderedIds): void {
            foreach ($orderedIds as $index => $id) {
                $assessment->questions()->whereKey($id)->update(['sort' => $index + 1]);
            }
        });
    }
}
