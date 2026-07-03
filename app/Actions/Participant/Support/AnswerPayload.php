<?php

namespace App\Actions\Participant\Support;

use App\Enums\QuestionType;
use App\Models\Question;
use Illuminate\Validation\ValidationException;

/**
 * Membangun dan memvalidasi payload jawaban sesuai kontrak per tipe soal:
 * - single_choice/likert: {"option_id": int}
 * - multiple_choice: {"option_ids": list<int>}
 * - most_least: {"most_option_id": int, "least_option_id": int} (harus berbeda)
 * - ranking: {"ordered_option_ids": list<int>} (seluruh opsi, tepat satu kali; urutan pertama = peringkat 1)
 * - text: {"text": string}
 */
class AnswerPayload
{
    /**
     * Normalisasi state Livewire menjadi payload siap simpan.
     * Mengembalikan null jika jawaban belum lengkap / kosong.
     *
     * @param  array{option_id?: mixed, option_ids?: mixed, most_option_id?: mixed, least_option_id?: mixed, ordered_option_ids?: mixed, text?: mixed}  $state
     * @return array<string, int|string|list<int>>|null
     */
    public static function fromState(Question $question, array $state): ?array
    {
        $validIds = $question->options->pluck('id')->all();

        return match ($question->type) {
            QuestionType::SingleChoice, QuestionType::Likert => self::single($state, $validIds),
            QuestionType::MultipleChoice => self::multiple($state, $validIds),
            QuestionType::MostLeast => self::mostLeast($state, $validIds),
            QuestionType::Ranking => self::ranking($state, $validIds),
            QuestionType::Text => self::text($state),
        };
    }

    /**
     * Apakah payload tersimpan merupakan jawaban lengkap dan valid untuk soal ini.
     *
     * @param  array<string, mixed>|null  $payload
     */
    public static function isComplete(Question $question, ?array $payload): bool
    {
        if ($payload === null) {
            return false;
        }

        $validIds = $question->options->pluck('id')->all();

        return match ($question->type) {
            QuestionType::SingleChoice, QuestionType::Likert => in_array((int) ($payload['option_id'] ?? 0), $validIds, true),
            QuestionType::MultipleChoice => self::allValid((array) ($payload['option_ids'] ?? []), $validIds),
            QuestionType::MostLeast => in_array($most = (int) ($payload['most_option_id'] ?? 0), $validIds, true)
                && in_array($least = (int) ($payload['least_option_id'] ?? 0), $validIds, true)
                && $most !== $least,
            QuestionType::Ranking => self::coversExactly(
                array_map(intval(...), (array) ($payload['ordered_option_ids'] ?? [])),
                $validIds,
            ),
            QuestionType::Text => trim((string) ($payload['text'] ?? '')) !== '',
        };
    }

    /**
     * Apakah $ids memuat seluruh $validIds tepat satu kali (tanpa duplikat/sisa).
     *
     * @param  list<int>  $ids
     * @param  list<int>  $validIds
     */
    public static function coversExactly(array $ids, array $validIds): bool
    {
        if (count($ids) !== count($validIds)) {
            return false;
        }

        sort($ids);
        sort($validIds);

        return $ids === $validIds;
    }

    /**
     * @param  array<string, mixed>  $state
     * @param  list<int>  $validIds
     * @return array{option_id: int}|null
     */
    private static function single(array $state, array $validIds): ?array
    {
        if (blank($state['option_id'] ?? null)) {
            return null;
        }

        return ['option_id' => self::assertValidId((int) $state['option_id'], $validIds, 'state.option_id')];
    }

    /**
     * @param  array<string, mixed>  $state
     * @param  list<int>  $validIds
     * @return array{option_ids: list<int>}|null
     */
    private static function multiple(array $state, array $validIds): ?array
    {
        $ids = array_values(array_unique(array_map(intval(...), (array) ($state['option_ids'] ?? []))));

        if ($ids === []) {
            return null;
        }

        foreach ($ids as $id) {
            self::assertValidId($id, $validIds, 'state.option_ids');
        }

        return ['option_ids' => $ids];
    }

    /**
     * @param  array<string, mixed>  $state
     * @param  list<int>  $validIds
     * @return array{most_option_id: int, least_option_id: int}|null
     */
    private static function mostLeast(array $state, array $validIds): ?array
    {
        if (blank($state['most_option_id'] ?? null) || blank($state['least_option_id'] ?? null)) {
            return null;
        }

        $most = self::assertValidId((int) $state['most_option_id'], $validIds, 'state.most_option_id');
        $least = self::assertValidId((int) $state['least_option_id'], $validIds, 'state.least_option_id');

        if ($most === $least) {
            throw ValidationException::withMessages([
                'state.least_option_id' => 'Pilihan "Paling Menggambarkan" dan "Paling Tidak Menggambarkan" harus berbeda.',
            ]);
        }

        return ['most_option_id' => $most, 'least_option_id' => $least];
    }

    /**
     * @param  array<string, mixed>  $state
     * @param  list<int>  $validIds
     * @return array{ordered_option_ids: list<int>}|null
     */
    private static function ranking(array $state, array $validIds): ?array
    {
        $ids = array_values(array_map(intval(...), (array) ($state['ordered_option_ids'] ?? [])));

        if ($ids === []) {
            return null;
        }

        if (! self::coversExactly($ids, $validIds)) {
            throw ValidationException::withMessages([
                'state.ordered_option_ids' => 'Urutan harus memuat seluruh opsi soal ini, masing-masing tepat satu kali.',
            ]);
        }

        return ['ordered_option_ids' => $ids];
    }

    /**
     * @param  array<string, mixed>  $state
     * @return array{text: string}|null
     */
    private static function text(array $state): ?array
    {
        $text = trim((string) ($state['text'] ?? ''));

        return $text === '' ? null : ['text' => $text];
    }

    /**
     * @param  list<int>  $validIds
     */
    private static function assertValidId(int $id, array $validIds, string $errorKey): int
    {
        if (! in_array($id, $validIds, true)) {
            throw ValidationException::withMessages([$errorKey => 'Pilihan tidak valid untuk soal ini.']);
        }

        return $id;
    }

    /**
     * @param  array<int, mixed>  $ids
     * @param  list<int>  $validIds
     */
    private static function allValid(array $ids, array $validIds): bool
    {
        return $ids !== [] && array_all($ids, fn (mixed $id): bool => in_array((int) $id, $validIds, true));
    }
}
