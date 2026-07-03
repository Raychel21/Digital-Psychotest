<?php

namespace App\Actions\Participant\Support;

use App\Models\Question;

/**
 * Menghidrasi payload jawaban tersimpan menjadi state Livewire untuk runner tes.
 *
 * ID disimpan sebagai string agar cocok dengan nilai input radio/checkbox di browser.
 * Referensi ke opsi yang sudah dihapus (stale) dibersihkan agar UI tidak rusak.
 */
class AnswerState
{
    /**
     * @param  array<string, mixed>|null  $payload
     * @return array{option_id: string|null, option_ids: list<string>, most_option_id: string|null, least_option_id: string|null, ordered_option_ids: list<string>, text: string}
     */
    public static function fromPayload(?Question $question, ?array $payload): array
    {
        $validIds = $question?->options->pluck('id')->all() ?? [];

        return [
            'option_id' => self::validIdOrNull($payload['option_id'] ?? null, $validIds),
            'option_ids' => self::validIds((array) ($payload['option_ids'] ?? []), $validIds),
            'most_option_id' => self::validIdOrNull($payload['most_option_id'] ?? null, $validIds),
            'least_option_id' => self::validIdOrNull($payload['least_option_id'] ?? null, $validIds),
            'ordered_option_ids' => self::orderedIds((array) ($payload['ordered_option_ids'] ?? []), $validIds),
            'text' => (string) ($payload['text'] ?? ''),
        ];
    }

    /**
     * @param  list<int>  $validIds
     */
    private static function validIdOrNull(mixed $id, array $validIds): ?string
    {
        if (blank($id) || ! in_array((int) $id, $validIds, true)) {
            return null;
        }

        return (string) (int) $id;
    }

    /**
     * @param  array<int, mixed>  $ids
     * @param  list<int>  $validIds
     * @return list<string>
     */
    private static function validIds(array $ids, array $validIds): array
    {
        return array_values(array_filter(
            array_map(fn (mixed $id): ?string => self::validIdOrNull($id, $validIds), $ids),
            fn (?string $id): bool => $id !== null,
        ));
    }

    /**
     * Urutan ranking hanya dipakai jika masih menutup seluruh opsi secara persis;
     * jika tidak (mis. ada opsi terhapus), kembalikan kosong agar UI memakai urutan default.
     *
     * @param  array<int, mixed>  $ids
     * @param  list<int>  $validIds
     * @return list<string>
     */
    private static function orderedIds(array $ids, array $validIds): array
    {
        $intIds = array_values(array_map(intval(...), $ids));

        if (! AnswerPayload::coversExactly($intIds, $validIds)) {
            return [];
        }

        return array_map(strval(...), $intIds);
    }
}
