<?php

namespace App\Actions\Builder;

use App\Models\Assessment;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Hapus soal (beserta berkas gambarnya) lalu rapikan ulang urutan soal.
 */
class DeleteQuestion
{
    public function handle(Question $question): void
    {
        DB::transaction(function () use ($question): void {
            $assessment = $question->assessment;

            $this->deleteImages($question);
            $question->options()->delete();
            $question->delete();

            $this->resequence($assessment);
        });
    }

    private function deleteImages(Question $question): void
    {
        $paths = [$question->image_path, ...$question->options->pluck('image_path')->all()];

        $paths = array_values(array_filter($paths, fn (?string $path): bool => is_string($path) && $path !== ''));

        if ($paths !== []) {
            Storage::disk('public')->delete($paths);
        }
    }

    private function resequence(Assessment $assessment): void
    {
        foreach ($assessment->questions()->orderBy('sort')->pluck('id') as $index => $id) {
            Question::query()->whereKey($id)->update(['sort' => $index + 1]);
        }
    }
}
