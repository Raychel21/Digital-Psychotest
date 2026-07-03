<?php

/**
 * Tabel norma DISC hasil porting dari DiscScoringService legacy.
 * Skor mentah berurutan dengan nilai plot sama dirapatkan menjadi
 * rentang [raw_min, raw_max, value]. Batas atas rentang terakhir
 * diperlebar hingga skor maksimum teoretis (24 soal).
 *
 * Skala "least" untuk I/S/C tidak memiliki tabel pada versi legacy,
 * sehingga sengaja dibiarkan kosong (NormConverter melakukan passthrough).
 * Rentang "change" berlaku sama untuk keempat dimensi (aproksimasi legacy),
 * dibatasi rentang teoretis -24 s.d. 24.
 *
 * @return array{
 *     most: array<string, list<array{0: int, 1: int, 2: int}>>,
 *     least: array<string, list<array{0: int, 1: int, 2: int}>>,
 *     change: list<array{0: int, 1: int, 2: int}>,
 * }
 */
return [
    'most' => [
        'D' => [[0, 0, -8], [1, 1, -6], [2, 3, -4], [4, 5, -2], [6, 7, 0], [8, 9, 2], [10, 12, 4], [13, 14, 6], [15, 24, 8]],
        'I' => [[0, 0, -6], [1, 2, -4], [3, 3, -2], [4, 4, 0], [5, 6, 2], [7, 8, 4], [9, 12, 6], [13, 13, 7], [14, 24, 8]],
        'S' => [[0, 0, -6], [1, 2, -4], [3, 3, -2], [4, 4, 0], [5, 6, 2], [7, 9, 4], [10, 12, 6], [13, 13, 7], [14, 24, 8]],
        'C' => [[0, 0, -6], [1, 1, -4], [2, 2, -2], [3, 3, 0], [4, 5, 2], [6, 7, 4], [8, 9, 6], [10, 10, 7], [11, 24, 8]],
    ],
    'least' => [
        'D' => [[0, 1, 8], [2, 2, 6], [3, 3, 4], [4, 5, 2], [6, 8, 0], [9, 11, -2], [12, 14, -4], [15, 16, -6], [17, 24, -8]],
    ],
    'change' => [
        [-24, -14, -8],
        [-13, -10, -6],
        [-9, -5, -4],
        [-4, -1, -2],
        [0, 0, 0],
        [1, 3, 4],
        [4, 5, 6],
        [6, 24, 8],
    ],
];
