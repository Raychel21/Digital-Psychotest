<?php

namespace App\Actions\Builder;

use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Duplikat soal beserta seluruh opsi & skornya, disisipkan tepat setelah aslinya.
 */
class DuplicateQuestion
{
    public function handle(Question $question): Question
    {
        return DB::transaction(function () use ($question): Question {
            $question->assessment->questions()
                ->where('sort', '>', $question->sort)
                ->increment('sort');

            $copy = $question->assessment->questions()->create([
                'type' => $question->type,
                'text' => $question->text,
                'sort' => $question->sort + 1,
                'required' => $question->required,
                'settings' => $question->settings,
                'logic' => $question->logic,
                'image_path' => $this->copyImage($question->image_path),
            ]);

            foreach ($question->options as $option) {
                $copy->options()->create([
                    'label' => $option->label,
                    'sort' => $option->sort,
                    'scores' => $option->scores,
                    'image_path' => $this->copyImage($option->image_path),
                ]);
            }

            return $copy->load('options');
        });
    }

    /**
     * Salin berkas gambar agar tiap soal punya berkas sendiri (aman saat salah satu dihapus).
     */
    private function copyImage(?string $path): ?string
    {
        $disk = Storage::disk('public');

        if (! is_string($path) || $path === '' || ! $disk->exists($path)) {
            return null;
        }

        $directory = pathinfo($path, PATHINFO_DIRNAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $newPath = ($directory === '.' ? '' : "{$directory}/")
            .Str::uuid()
            .($extension === '' ? '' : ".{$extension}");

        $disk->copy($path, $newPath);

        return $newPath;
    }
}
