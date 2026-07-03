<?php

namespace App\Actions\Builder;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Hapus satu opsi lalu rapikan ulang urutan opsi pada soalnya.
 */
class DeleteOption
{
    public function handle(Option $option): void
    {
        DB::transaction(function () use ($option): void {
            $question = $option->question;

            if (is_string($option->image_path) && $option->image_path !== '') {
                Storage::disk('public')->delete($option->image_path);
            }

            $option->delete();

            $this->resequence($question);
        });
    }

    private function resequence(Question $question): void
    {
        foreach ($question->options()->orderBy('sort')->pluck('id') as $index => $id) {
            Option::query()->whereKey($id)->update(['sort' => $index + 1]);
        }
    }
}
