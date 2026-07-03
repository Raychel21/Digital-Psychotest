<?php

namespace App\Actions\Builder;

use App\Models\Question;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * Perbarui atribut soal dari builder (teks, wajib, gambar).
 */
class UpdateQuestion
{
    /**
     * @param  array{text?: string, required?: bool, image_path?: string|null}  $data
     */
    public function handle(Question $question, array $data): Question
    {
        $data = Arr::only($data, ['text', 'required', 'image_path']);

        if (array_key_exists('image_path', $data) && $data['image_path'] !== $question->image_path) {
            $this->deleteImage($question->image_path);
        }

        if (array_key_exists('required', $data)) {
            $data['required'] = (bool) $data['required'];
        }

        if (array_key_exists('text', $data)) {
            $data['text'] = (string) $data['text'];
        }

        $question->update($data);

        return $question;
    }

    private function deleteImage(?string $path): void
    {
        if (is_string($path) && $path !== '') {
            Storage::disk('public')->delete($path);
        }
    }
}
