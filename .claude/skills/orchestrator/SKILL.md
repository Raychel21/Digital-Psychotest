---
name: orchestrator
description: Loop pengembangan otonom menuju 15+ alat tes production-ready. Membaca state di .claude/orchestrator/, mengerjakan item backlog satu per satu (rencana → implementasi → verifikasi → commit → catat), dan selalu bisa dilanjutkan sesi baru setelah session limit. Gunakan saat user bilang "lanjutkan", "orchestrator", "kerjakan backlog", atau sesi baru dimulai tanpa instruksi spesifik.
---

# Orchestrator Psychotest

Kamu adalah orchestrator proyek ini. Tujuan akhir: platform psikotes production-ready dengan 15+ alat tes akurat (lihat `BACKLOG.md`). Bekerja dalam siklus kecil yang selalu meninggalkan repo dalam keadaan hijau dan state tertulis di disk — session limit tidak boleh menghilangkan apa pun.

## File state (semua di `.claude/orchestrator/`)
- `STATE.md` — sedang dikerjakan, fase siklus, langkah berikut. SATU-SATUNYA sumber kebenaran resume.
- `BACKLOG.md` — antrean item + DEFINITION OF DONE.
- `DONE.md` — riwayat selesai (tanggal, item, commit, bukti).
- `tasks/<item>.md` — rencana + progres per item yang sedang berjalan.

## Prosedur (setiap invokasi)
1. Baca `STATE.md`, `BACKLOG.md`, dan `.claude/memory/PROGRESS.md` (konteks arsitektur).
2. Jika `SEDANG DIKERJAKAN` ≠ idle → lanjutkan dari fase yang tercatat, JANGAN mengulang dari awal. Baca `tasks/<item>.md` untuk detail posisi terakhir.
3. Jika idle → ambil item teratas yang belum dicentang di `BACKLOG.md`, tulis ke `STATE.md` (item + fase `rencana`), lalu mulai siklus.

## Siklus per item (fase ditulis ke STATE.md sebelum dan sesudah)
1. **rencana** — tulis rencana ringkas ke `tasks/<item>.md`: file yang disentuh, kontrak data, langkah, cara verifikasi. Cek dokumentasi terbaru (`search-docs`) sebelum menetapkan API.
2. **implementasi** — kerjakan langkah demi langkah; coret langkah selesai di `tasks/<item>.md` segera setelah tiap langkah (bukan di akhir). Pekerjaan besar dan terisolasi boleh didelegasikan ke subagent `psy-worker`; sertakan path `tasks/<item>.md` di prompt-nya.
3. **verifikasi** — `php artisan test --compact` hijau penuh, `vendor/bin/pint --dirty`, `npm run build`, lalu uji alur nyata via Chrome DevTools MCP (login → aksi → screenshot; console wajib bersih). Item alat tes wajib membuktikan angka skoring lewat feature test.
4. **commit** — commit atomik (format Conventional Commits, tanpa atribusi AI). Jangan push tanpa diminta.
5. **catat** — centang item di `BACKLOG.md`, tambah baris di `DONE.md`, perbarui `PROGRESS.md` bila arsitektur berubah, hapus `tasks/<item>.md`, set `STATE.md` ke idle + `LANGKAH BERIKUT` = item berikutnya.
6. Ulangi ke item berikutnya. Berhenti hanya jika: backlog habis, user menghentikan, atau butuh keputusan yang hanya bisa dijawab user (tulis pertanyaannya di `STATE.md` → `LANGKAH BERIKUT` sebelum bertanya).

## Aturan tahan-session-limit
- Tulis state SEBELUM tindakan berisiko panjang (spawn subagent, migrasi, refactor besar) — bukan sesudah saja.
- Commit kecil dan sering; jangan menumpuk >1 item dalam satu commit.
- Subagent: satu pekerjaan besar pada satu waktu; instruksinya harus lengkap-mandiri (subagent baru tidak mewarisi percakapan) dan menyebut file task untuk ditulis ulang progresnya.
- Jangan mengandalkan ingatan percakapan untuk keputusan penting — semua keputusan masuk `tasks/<item>.md` atau `PROGRESS.md`.

## Aturan kualitas
- Patuhi `.claude/rules/` (≤200 baris, tanpa komentar, UI non-native, dokumentasi terbaru, /find-skills).
- Ikuti DEFINITION OF DONE di `BACKLOG.md` — item belum selesai sebelum semua poin terpenuhi.
