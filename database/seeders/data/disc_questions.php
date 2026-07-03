<?php

/**
 * Data soal DISC legacy: 24 kelompok, masing-masing 4 pernyataan.
 * Format tiap item: [pernyataan, huruf MOST, huruf LEAST].
 * Huruf "N" adalah pengisi netral: tidak terdaftar sebagai dimensi
 * sehingga otomatis diabaikan oleh ScoreAccumulator.
 *
 * @return array<int, list<array{0: string, 1: string, 2: string}>>
 */
return [
    1 => [
        ['Mudah bergaul, ramah', 'S', 'S'],
        ['Penuh kepercayaan, Percaya kepada orang lain', 'I', 'I'],
        ['Petualang, pengambil risiko', 'N', 'D'],
        ['Toleran, Penuh hormat', 'C', 'C'],
    ],
    2 => [
        ['Yang penting adalah hasil', 'D', 'D'],
        ['Melakukan dengan benar, Ketepatan dihitung', 'C', 'C'],
        ['Buat menjadi menyenangkan', 'N', 'I'],
        ['Mari melakukan bersama', 'N', 'S'],
    ],
    3 => [
        ['Pendidikan, Kebudayaan', 'N', 'C'],
        ['Pencapaian, Penghargaan', 'D', 'D'],
        ['Keselamatan, Keamanan', 'S', 'S'],
        ['Sosial, Pertemuan kelompok', 'I', 'N'],
    ],
    4 => [
        ['Lembut, Pendiam', 'C', 'N'],
        ['Optimis, Pengkhayal', 'D', 'D'],
        ['Pusat perhatian, Mudah bersosialisasi', 'N', 'I'],
        ['Pembuat perdamaian, Membawa ketenangan', 'S', 'S'],
    ],
    5 => [
        ['Akan melakukan tanpa, Kontrol diri', 'N', 'C'],
        ['Akan membeli berdasarkan hasrat', 'D', 'D'],
        ['Akan menunggu, Tidak ada tekanan', 'S', 'S'],
        ['Akan membelanjakan apa yang saya inginkan', 'I', 'N'],
    ],
    6 => [
        ['Bertanggung jawab, Pendekatan langsung', 'D', 'D'],
        ['Mudah bergaul, Antusias', 'N', 'I'],
        ['Mudah ditebak, Konsisten', 'N', 'S'],
        ['Waspada, Berhati-hati', 'C', 'N'],
    ],
    7 => [
        ['Mendorong orang lain', 'I', 'I'],
        ['Berjuang demi kesempurnaan', 'N', 'C'],
        ['Menjadi bagian tim', 'N', 'S'],
        ['Ingin mencapai tujuan', 'D', 'N'],
    ],
    8 => [
        ['Ramah, Mudah berteman', 'S', 'N'],
        ['Unik, Bosan dengan rutinitas', 'N', 'I'],
        ['Aktif merubah hal-hal', 'D', 'D'],
        ['Menginginkan sesuatu yang pasti', 'C', 'C'],
    ],
    9 => [
        ['Tidak mudah dikalahkan', 'D', 'D'],
        ['Akan melakukan sesuai perintah, Mengikuti pimpinan', 'S', 'N'],
        ['Riang, Ceria', 'I', 'I'],
        ['Ingin segalanya teratur, Rapi', 'N', 'C'],
    ],
    10 => [
        ['Pendekatan langsung, Tanpa basa-basi', 'D', 'D'],
        ['Suka bergaul, Antusias', 'I', 'I'],
        ['Terukur, Dapat diandalkan', 'S', 'S'],
        ['Berhati-hati, Teliti', 'C', 'C'],
    ],
    11 => [
        ['Berani, Pengambil risiko', 'D', 'D'],
        ['Ekspresif, Banyak bicara', 'I', 'I'],
        ['Stabil, Sabar', 'S', 'S'],
        ['Tepat, Detail', 'C', 'C'],
    ],
    12 => [
        ['Menyukai tantangan, Kompetitif', 'D', 'D'],
        ['Optimis, Positif', 'I', 'I'],
        ['Akomodatif, Membantu', 'S', 'S'],
        ['Logis, Analitis', 'C', 'C'],
    ],
    13 => [
        ['Hidup, Cerewet', 'I', 'N'],
        ['Bekerja dengan cepat, Tekun', 'D', 'D'],
        ['Mencoba mempertahankan keseimbangan', 'S', 'S'],
        ['Mencoba mengikuti aturan', 'N', 'C'],
    ],
    14 => [
        ['Menginginkan kemajuan', 'D', 'D'],
        ['Puas dengan beberapa hal, Mudah puas', 'S', 'N'],
        ['Menggambarkan perasaan secara terbuka', 'I', 'N'],
        ['Rendah hati, sederhana', 'N', 'C'],
    ],
    15 => [
        ['Memikirkan orang lain dahulu', 'S', 'S'],
        ['Kompetitif, Menyukai tantangan', 'N', 'I'],
        ['Optimis, Positif', 'D', 'D'],
        ['Berpikir logis, Sistematis', 'C', 'C'],
    ],
    16 => [
        ['Mengatur waktu secara efisien', 'C', 'N'],
        ['Sering terburu-buru, Merasa tertekan', 'D', 'D'],
        ['Hal-hal sosial merupakan hal yang penting', 'I', 'I'],
        ['Menyelesaikan apa yang telah dimulai', 'S', 'S'],
    ],
    17 => [
        ['Tenang, Pendiam', 'C', 'C'],
        ['Bahagia, Riang', 'I', 'I'],
        ['Menyenangkan, Baik', 'S', 'N'],
        ['Tegas, Berani', 'D', 'D'],
    ],
    18 => [
        ['Menyenangkan orang, Ramah', 'S', 'S'],
        ['Tertawa keras, hidup', 'N', 'I'],
        ['Berani, tegas', 'D', 'D'],
        ['Tenang, Pendiam', 'C', 'C'],
    ],
    19 => [
        ['Menolak perubahan mendadak', 'S', 'N'],
        ['Cenderung sering berjanji', 'I', 'I'],
        ['Menyendiri jika dibawah tekanan', 'N', 'C'],
        ['Tidak takut berkelahi', 'N', 'D'],
    ],
    20 => [
        ['Menghabiskan waktu berharga dengan orang lain', 'S', 'S'],
        ['Merencanakan masa depan, Menyiapkan diri', 'C', 'N'],
        ['Perjalanan menuju petualangan baru', 'I', 'I'],
        ['Mendapat penghargaan jika mencapai tujuan', 'D', 'D'],
    ],
    21 => [
        ['Menginginkan kekuasaan lebih', 'N', 'D'],
        ['Menginginkan kesempatan baru', 'I', 'N'],
        ['Menghindari konflik apapun', 'S', 'S'],
        ['Menginginkan arah yang jelas', 'N', 'C'],
    ],
    22 => [
        ['Seorang pendukung yang baik', 'I', 'I'],
        ['Seorang pendengar yang baik', 'S', 'S'],
        ['Seorang penganalisa yang baik', 'C', 'C'],
        ['Seorang delegasi yang baik', 'D', 'D'],
    ],
    23 => [
        ['Peraturan perlu ditolak', 'N', 'D'],
        ['Peraturan membuat adil', 'C', 'N'],
        ['Peraturan membuat bosan', 'I', 'I'],
        ['Peraturan membuat aman', 'S', 'S'],
    ],
    24 => [
        ['Bisa diandalkan, Bisa digantungkan', 'N', 'S'],
        ['Kreatif, Unik', 'I', 'I'],
        ['Berorientasi kepada hasil, Inti', 'D', 'N'],
        ['Memegang teguh standar tinggi, Akurat', 'C', 'N'],
    ],
];
