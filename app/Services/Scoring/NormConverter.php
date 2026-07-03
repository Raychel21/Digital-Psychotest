<?php

namespace App\Services\Scoring;

use App\Models\Assessment;
use Illuminate\Support\Collection;

/**
 * Konversi skor mentah ke nilai norma berdasarkan tabel `norms` per dimensi.
 * Tanpa baris norma yang cocok, skor mentah diteruskan apa adanya (passthrough).
 */
class NormConverter
{
    /**
     * @param  array<string, array<string, int>>  $rawScores
     * @return array<string, array<string, int>>
     */
    public function convert(Assessment $assessment, array $rawScores): array
    {
        $assessment->loadMissing('dimensions.norms');

        $dimensions = $assessment->dimensions->keyBy('code');
        $normScores = [];

        foreach ($rawScores as $scale => $dimensionScores) {
            foreach ($dimensionScores as $code => $raw) {
                $norms = $dimensions->get($code)?->norms ?? new Collection;

                $match = $norms->first(
                    fn ($norm): bool => $norm->scale->value === $scale
                        && $raw >= $norm->raw_min
                        && $raw <= $norm->raw_max,
                );

                $normScores[$scale][$code] = $match?->value ?? $raw;
            }
        }

        return $normScores;
    }
}
