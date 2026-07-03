<?php

/**
 * Interpretasi DISC legacy per dimensi.
 * Format: kode dimensi => [judul (personalityLabels), isi (interpretations)].
 *
 * @return array<string, array{0: string, 1: string}>
 */
return [
    'D' => [
        'Dominance (Dominan, Tegas, Pengambil Risiko)',
        'Memiliki dorongan kuat untuk mengontrol lingkungan dan mencapai hasil. Sangat mandiri, berorientasi pada target, dan tidak ragu mengambil tantangan. Terkadang bisa terlihat terlalu menuntut atau agresif.',
    ],
    'I' => [
        'Influence (Berpengaruh, Antusias, Ramah)',
        'Suka bersosialisasi, persuasif, dan sangat optimis. Cenderung menjadi pusat perhatian dan pandai memotivasi orang lain. Terkadang kurang fokus pada detail dan lebih mengandalkan emosi/intuisi.',
    ],
    'S' => [
        'Steadiness (Stabil, Sabar, Pendengar Baik)',
        'Tenang, sabar, dan sangat menghargai harmoni. Merupakan pendengar yang baik dan anggota tim yang dapat diandalkan. Terkadang kurang menyukai perubahan mendadak atau konflik terbuka.',
    ],
    'C' => [
        'Conscientiousness (Teliti, Analitis, Taat Aturan)',
        'Sangat teliti, analitis, dan berorientasi pada standar tinggi. Selalu memastikan akurasi dan kualitas kerja. Terkadang terlalu perfeksionis dan terlalu banyak menganalisis sebelum bertindak.',
    ],
];
