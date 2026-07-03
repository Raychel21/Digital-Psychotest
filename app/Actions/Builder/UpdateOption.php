<?php

namespace App\Actions\Builder;

use App\Filament\Resources\Assessments\Support\OptionScoresMapper;
use App\Models\Option;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

/**
 * Perbarui opsi dari builder: label, gambar, dan skor.
 *
 * Field skor virtual (`most_code`, `least_code`, `scores`) diterjemahkan ke
 * json `scores` lewat OptionScoresMapper — sama persis dengan UX fase 1.
 */
class UpdateOption
{
    /**
     * @param  array{label?: string, image_path?: string|null, most_code?: string|null, least_code?: string|null, scores?: array<string, mixed>}  $data
     */
    public function handle(Option $option, array $data): Option
    {
        $data = Arr::only($data, ['label', 'image_path', 'most_code', 'least_code', 'scores']);

        if (array_key_exists('image_path', $data) && $data['image_path'] !== $option->image_path) {
            $this->deleteImage($option->image_path);
        }

        if (array_key_exists('label', $data)) {
            $data['label'] = (string) $data['label'];
        }

        if ($this->touchesScores($data)) {
            $data = $this->applyScores($option, $data);
        }

        $option->update($data);

        return $option;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function touchesScores(array $data): bool
    {
        return array_key_exists('scores', $data)
            || array_key_exists('most_code', $data)
            || array_key_exists('least_code', $data);
    }

    /**
     * Lengkapi field virtual yang tidak dikirim dengan nilai tersimpan agar
     * pembaruan parsial (mis. hanya most_code) tidak menghapus skor lain.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function applyScores(Option $option, array $data): array
    {
        $type = $option->question->type;

        $data['most_code'] ??= OptionScoresMapper::mostCode($option->scores);
        $data['least_code'] ??= OptionScoresMapper::leastCode($option->scores);
        $data['scores'] = is_array($data['scores'] ?? null)
            ? $data['scores']
            : OptionScoresMapper::keyValueScores($option->scores);

        return OptionScoresMapper::apply($data, $type);
    }

    private function deleteImage(?string $path): void
    {
        if (is_string($path) && $path !== '') {
            Storage::disk('public')->delete($path);
        }
    }
}
