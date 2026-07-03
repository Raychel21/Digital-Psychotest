# BACKLOG — menuju 15+ alat tes production-ready

> Urut prioritas. Satu item = satu siklus orchestrator (branch/commit sendiri, test hijau, verifikasi browser).
> Definisi selesai per item ada di bagian bawah (DEFINITION OF DONE).

## P0 — Fondasi platform (prasyarat banyak alat tes)
- [ ] F1. Sections/page-break: model Section (judul, instruksi, urutan), soal milik section, runner per-halaman-section.
- [ ] F2. Timer per section (menit per section, auto-lanjut saat habis; server tetap sumber kebenaran).
- [ ] F3. Presentasi matriks Likert (grid pernyataan × skala) di runner + builder.
- [ ] F4. Grid numerik berkecepatan (kolom angka, input cepat, auto-scroll, hitung per interval) — mesin Kraepelin/Pauli.
- [ ] F5. Norma bertingkat: filter norma per usia/jenjang pendidikan/gender (kolom kriteria pada norms).
- [ ] F6. Export hasil ke PDF + grafik profil dimensi di halaman hasil (chart, tanpa CDN).
- [ ] F7. Bank soal bergambar massal: upload zip/multi-image untuk subtest visual.

## P1 — Alat tes kepribadian & minat (memakai fondasi yang ada)
- [x] T1. DISC (24 most/least) — sudah ada, jadikan acuan kualitas.
- [ ] T2. Big Five / IPIP-50 (likert 5, 5 dimensi OCEAN, skor terbalik).
- [ ] T3. EPPS (forced-choice pasangan A/B, 15 kebutuhan, ipsatif).
- [ ] T4. PAPI Kostick (90 pasangan forced-choice, 20 skala, roda PAPI di hasil).
- [ ] T5. Holland RIASEC / SDS (aktivitas-kompetensi-okupasi, kode 3 huruf).
- [ ] T6. RMIB (ranking 12 kategori pekerjaan per kelompok).
- [ ] T7. Tipologi 16 tipe gaya MBTI (dikotomi E/I S/N T/F J/P; likert/forced-choice).
- [ ] T8. 16PF-lite (likert 3 pilihan, 16 faktor).
- [ ] T9. DASS-21 (skrining depresi-ansietas-stres; likert 4; cut-off kategori).

## P2 — Alat tes kognitif & kecepatan (butuh P0)
- [ ] T10. Kraepelin (F4; grafik panker: kecepatan, ketelitian, keajekan, ketahanan).
- [ ] T11. Pauli (varian F4, durasi panjang, penilaian per 3 menit).
- [ ] T12. IST (9 subtest, timer per subtest, campuran verbal-numerik-figural bergambar).
- [ ] T13. CFIT Skala 3 (4 subtest figural bergambar, timer ketat).
- [ ] T14. Raven SPM (60 matriks bergambar, 5 set).
- [ ] T15. TIU/TKD (verbal, numerik, logika; timer per section).
- [ ] T16. Army Alpha (instruksi audio/teks bertahap, jawaban mengikuti perintah).

## P3 — Kesiapan produksi
- [ ] PR1. Rate limiting + audit login (throttle, log aktivitas admin).
- [ ] PR2. Backup DB terjadwal + queue worker untuk skoring berat.
- [ ] PR3. Deploy guide (Laravel Cloud/VPS): env produksi, storage:link, cache config/route/view, HTTPS.
- [ ] PR4. Seeder demo lengkap semua alat tes + smoke test e2e per alat tes.
- [ ] PR5. Halaman kelola profil peserta (biodata: usia, pendidikan, gender — untuk F5).

## DEFINITION OF DONE (setiap item)
1. Skoring akurat data-driven (raw → norma → interpretasi) dengan feature test yang membuktikan angka.
2. Bisa disusun via builder tanpa koding; seeder contoh tersedia.
3. Runner teruji via Chrome DevTools MCP (screenshot + console bersih + alur submit → hasil).
4. `php artisan test --compact` hijau penuh; `vendor/bin/pint --dirty` bersih; `npm run build` sukses.
5. Ikut `.claude/rules/` (≤200 baris, tanpa komentar, UI non-native, bahasa Indonesia natural).
6. Commit atomik + STATE.md/DONE.md diperbarui.
