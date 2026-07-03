# Pola Kode Wajib

Aturan ini berlaku untuk SEMUA kode yang ditulis atau diubah di repo ini, oleh siapa pun (manusia maupun agent).

## Batas 200 baris
- Satu file kode maksimal **200 baris**. Jika hasil edit melewati batas, WAJIB refactor sebelum selesai: pecah ke trait/Concerns, Action di `app/Actions/`, Service di `app/Services/`, partial blade, atau modul JS terpisah.
- Berlaku untuk PHP, Blade, JS, dan CSS. File konfigurasi/vendor/lang dikecualikan.

## Bersih dari komentar
- Kode TIDAK boleh mengandung komentar inline atau komentar naratif ("// simpan data", "// loop opsi").
- Satu-satunya pengecualian: PHPDoc yang memuat kontrak tipe (`@param`, `@return`, array shapes) karena dibutuhkan analisis statis.
- Nama variabel/metode deskriptif menggantikan fungsi komentar. Jika kode butuh penjelasan, refactor sampai tidak butuh.
- Saat menyentuh file lama yang masih berkomentar: hapus komentarnya dalam edit yang sama.

## Dokumentasi terbaru dulu, baru menulis kode
- Sebelum memakai API Laravel/Filament/Livewire: jalankan `search-docs` (Laravel Boost) — versi terpasang otomatis diperhitungkan.
- Untuk library non-Laravel (Blockly, SortableJS, dll.): pakai context7 atau WebFetch ke dokumentasi resmi terbaru. Jangan menulis dari ingatan untuk API yang bisa berubah.
- Kontrak namespace Filament v5: `.claude/skills/laravel-filament/references/namespaces.md`.

## Gunakan skills yang tersedia
- Sebelum mengerjakan tugas bertipe umum (review, commit, debug, UI, dsb.), cek daftar skills yang ada dan pakai yang cocok.
- Jika butuh kemampuan yang sepertinya belum ada, jalankan `/find-skills` untuk mencari dan memasang skill yang relevan sebelum menulis solusi manual.
