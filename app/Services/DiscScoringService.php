<?php

namespace App\Services;

use App\Models\Participant;
use App\Models\DiscAnswer;

class DiscScoringService
{
    /**
     * Menghitung total kemunculan MOST dan LEAST untuk D, I, S, C, N
     * serta nilai CHANGE.
     *
     * @param int $participantId
     * @return array
     */
    public function calculateRawScores($participantId)
    {
        $participant = Participant::with(['answers.mostItem', 'answers.leastItem'])
            ->findOrFail($participantId);

        // Inisialisasi struktur skor mentah
        $rawScores = [
            'most' => ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0, 'N' => 0, 'total' => 0],
            'least' => ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0, 'N' => 0, 'total' => 0],
            'change' => ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0]
        ];

        // 1 & 2. Mengambil jawaban dan menghitung total MOST & LEAST
        foreach ($participant->answers as $answer) {
            if ($answer->mostItem) {
                $mostValue = $answer->mostItem->most_value;
                if (isset($rawScores['most'][$mostValue])) {
                    $rawScores['most'][$mostValue]++;
                }
                $rawScores['most']['total']++;
            }

            if ($answer->leastItem) {
                $leastValue = $answer->leastItem->least_value;
                if (isset($rawScores['least'][$leastValue])) {
                    $rawScores['least'][$leastValue]++;
                }
                $rawScores['least']['total']++;
            }
        }

        // 3. Menghitung nilai CHANGE = MOST - LEAST
        $dimensions = ['D', 'I', 'S', 'C'];
        foreach ($dimensions as $dim) {
            $rawScores['change'][$dim] = $rawScores['most'][$dim] - $rawScores['least'][$dim];
        }

        return $rawScores;
    }

    /**
     * Konversi Raw Score ke nilai Norma/Grafik (-8 s.d +8)
     * Data array ini merupakan contoh kerangka norma DiSC. 
     * Silakan sesuaikan range angkanya agar 100% akurat dengan Gambar 1.
     *
     * @param array $rawScores (Hasil dari fungsi calculateRawScores)
     * @return array
     */
    public function convertRawToNorm(array $rawScores)
    {
        return [
            'graph_1' => [
                'D' => $this->mapToNorm('most', 'D', $rawScores['most']['D']),
                'I' => $this->mapToNorm('most', 'I', $rawScores['most']['I']),
                'S' => $this->mapToNorm('most', 'S', $rawScores['most']['S']),
                'C' => $this->mapToNorm('most', 'C', $rawScores['most']['C']),
            ],
            'graph_2' => [
                'D' => $this->mapToNorm('least', 'D', $rawScores['least']['D']),
                'I' => $this->mapToNorm('least', 'I', $rawScores['least']['I']),
                'S' => $this->mapToNorm('least', 'S', $rawScores['least']['S']),
                'C' => $this->mapToNorm('least', 'C', $rawScores['least']['C']),
            ],
            'graph_3' => [
                'D' => $this->mapToNorm('change', 'D', $rawScores['change']['D']),
                'I' => $this->mapToNorm('change', 'I', $rawScores['change']['I']),
                'S' => $this->mapToNorm('change', 'S', $rawScores['change']['S']),
                'C' => $this->mapToNorm('change', 'C', $rawScores['change']['C']),
            ],
        ];
    }

    /**
     * Fungsi Helper untuk memetakan nilai berdasarkan tabel norma standar.
     * Array ini disusun berdasarkan aproksimasi norma standar DISC (Gambar 1).
     */
    private function mapToNorm($type, $dimension, $score)
    {
        // STRUKTUR NORMA SEDERHANA
        // Format: Raw Score => Plot Value (-8 to 8)
        $norms = [
            'most' => [
                // Contoh Mapping D MOST
                'D' => [
                    0=>-8, 1=>-6, 2=>-4, 3=>-4, 4=>-2, 5=>-2, 6=>0, 7=>0, 
                    8=>2, 9=>2, 10=>4, 11=>4, 12=>4, 13=>6, 14=>6, 15=>8, 16=>8, 17=>8, 18=>8, 19=>8, 20=>8, 21=>8
                ],
                'I' => [
                    0=>-6, 1=>-4, 2=>-4, 3=>-2, 4=>0, 5=>2, 6=>2, 7=>4, 8=>4, 
                    9=>6, 10=>6, 11=>6, 12=>6, 13=>7, 14=>8, 15=>8, 16=>8, 17=>8, 18=>8, 19=>8
                ],
                'S' => [
                    0=>-6, 1=>-4, 2=>-4, 3=>-2, 4=>0, 5=>2, 6=>2, 7=>4, 8=>4, 9=>4, 
                    10=>6, 11=>6, 12=>6, 13=>7, 14=>8, 15=>8, 16=>8, 17=>8, 18=>8, 19=>8, 20=>8
                ],
                'C' => [
                    0=>-6, 1=>-4, 2=>-2, 3=>0, 4=>2, 5=>2, 6=>4, 7=>4, 8=>6, 9=>6, 
                    10=>7, 11=>8, 12=>8, 13=>8, 14=>8, 15=>8, 16=>8, 17=>8
                ]
            ],
            'least' => [
                'D' => [
                    0=>8, 1=>8, 2=>6, 3=>4, 4=>2, 5=>2, 6=>0, 7=>0, 8=>0, 
                    9=>-2, 10=>-2, 11=>-2, 12=>-4, 13=>-4, 14=>-4, 15=>-6, 16=>-6, 17=>-8, 18=>-8, 19=>-8, 20=>-8
                ],
                // Placeholder, default logik diterapkan di bawah jika tidak ada
                'I' => [], 'S' => [], 'C' => []
            ],
            'change' => [
                // Nilai change bisa dari -24 hingga +24
                'D' => [], 'I' => [], 'S' => [], 'C' => []
            ]
        ];

        // Mengembalikan nilai mapping jika tersedia
        if (isset($norms[$type][$dimension][$score])) {
            return $norms[$type][$dimension][$score];
        }

        // --- FALLBACK RETURN ---
        // Jika raw score tidak ditemukan di map di atas, ini adalah logika fallback 
        // (Bisa dihapus jika array $norms di atas sudah Anda lengkapi seluruhnya 0-24)
        if ($type === 'change') {
            // Aproksimasi sederhana untuk Change (Graph 3)
            if ($score >= 6) return 8;
            if ($score >= 4) return 6;
            if ($score >= 1) return 4;
            if ($score == 0) return 0;
            if ($score >= -4) return -2;
            if ($score >= -9) return -4;
            if ($score >= -13) return -6;
            return -8;
        }

        return 0; // Return titik nol (0) jika data tidak terpetakan
    }
}
