<?php

namespace App\Filament\Resources\Attempts\Schemas;

use App\Models\Attempt;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AttemptInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Pengerjaan')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Peserta'),
                        TextEntry::make('assessment.name')
                            ->label('Alat Tes'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge(),
                        TextEntry::make('invitation.code')
                            ->label('Kode undangan')
                            ->placeholder('—'),
                        TextEntry::make('started_at')
                            ->label('Dimulai')
                            ->dateTime(),
                        TextEntry::make('completed_at')
                            ->label('Selesai')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('answers_count')
                            ->label('Jumlah soal terjawab')
                            ->state(fn (Attempt $record): int => $record->answers()->count()),
                        TextEntry::make('current_index')
                            ->label('Posisi soal terakhir'),
                    ]),
                Section::make('Hasil')
                    ->columns(1)
                    ->visible(fn (Attempt $record): bool => $record->result !== null)
                    ->schema([
                        KeyValueEntry::make('raw_scores_display')
                            ->label('Skor Mentah')
                            ->keyLabel('Skala')
                            ->valueLabel('Skor per dimensi')
                            ->state(fn (Attempt $record): array => self::flattenScores($record->result?->raw_scores)),
                        KeyValueEntry::make('norm_scores_display')
                            ->label('Skor Norma')
                            ->keyLabel('Skala')
                            ->valueLabel('Skor per dimensi')
                            ->state(fn (Attempt $record): array => self::flattenScores($record->result?->norm_scores)),
                        KeyValueEntry::make('summary_display')
                            ->label('Ringkasan')
                            ->keyLabel('Kunci')
                            ->valueLabel('Nilai')
                            ->state(fn (Attempt $record): array => self::flattenSummary($record->result?->summary)),
                    ]),
                Section::make('Hasil')
                    ->visible(fn (Attempt $record): bool => $record->result === null)
                    ->schema([
                        TextEntry::make('no_result')
                            ->hiddenLabel()
                            ->state('Belum ada hasil untuk pengerjaan ini.'),
                    ]),
            ]);
    }

    /**
     * Flattens {"sum": {"D": 10, "I": 3}, ...} into ["sum" => "D: 10, I: 3", ...].
     *
     * @param  array<string, array<string, int|float>>|null  $scores
     * @return array<string, string>
     */
    private static function flattenScores(?array $scores): array
    {
        return collect($scores ?? [])
            ->map(fn (array $values): string => collect($values)
                ->map(fn (int|float $points, string $code): string => "{$code}: {$points}")
                ->implode(', '))
            ->all();
    }

    /**
     * @param  array<string, mixed>|null  $summary
     * @return array<string, string>
     */
    private static function flattenSummary(?array $summary): array
    {
        return collect($summary ?? [])
            ->map(function (mixed $value): string {
                if (! is_array($value)) {
                    return (string) $value;
                }

                return collect($value)
                    ->map(fn (mixed $item): string => is_array($item)
                        ? (string) ($item['title'] ?? json_encode($item))
                        : (string) $item)
                    ->implode('; ');
            })
            ->all();
    }
}
