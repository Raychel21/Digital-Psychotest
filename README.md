# Psychotest — Platform Tes Psikologi Online

Platform no-code untuk menyusun, menjalankan, dan menilai tes psikologi secara akurat: builder soal drag-and-drop dengan logika blok (Blockly → JsonLogic), skoring data-driven (skor mentah → norma → interpretasi), dan tiga panel peran. Target: **15+ alat tes production-ready** (roadmap di `.claude/orchestrator/BACKLOG.md`).

## Stack

| Komponen | Versi |
| --- | --- |
| PHP / Laravel | 8.5 / 12 |
| Filament (SPA mode) | v5 |
| Tailwind CSS | v4 |
| Database | SQLite (dev) |
| JS | Alpine (bawaan Livewire), SortableJS, Blockly |

## Menjalankan secara lokal

```bash
git clone <url-fork-anda> && cd psychotest
composer install && npm install
cp .env.example .env && php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
npm run build          # atau: composer run dev (server + vite + queue + pail)
php artisan serve
```

Akun demo (password semua: `password`):

| Peran | Email | Panel |
| --- | --- | --- |
| Developer | developer@psychotest.test | `/developer` |
| Administrator | admin@psychotest.test | `/admin` |
| Peserta | participant@psychotest.test | `/participant` |

Login tunggal di `/login`; setiap peran diarahkan ke panelnya. Alur peserta: admin membuat kode undangan (`/admin/invitations`) → peserta menukarkan kode di dasbor → mengerjakan tes → hasil + interpretasi langsung tersedia.

## Peta arah kode

| Lokasi | Isi |
| --- | --- |
| `app/Actions/`, `app/Services/` | Seluruh logika bisnis (scoring, builder, undangan). Resource/Page Filament hanya delegasi. |
| `app/Filament/{Resources,Developer,Participant}` | Tiga panel: admin (indigo), developer (rose), peserta (emerald). |
| `resources/views/filament/admin/builder/` | Builder visual + partials + modal Blockly. |
| `resources/css/chrome.css` | Kustomisasi chrome browser (scrollbar, radio/checkbox, dst.) — dipakai semua panel + landing. |
| `lang/id/`, `lang/vendor/` | Terjemahan Indonesia natural; override string vendor yang kaku. |
| `database/seeders/data/` | Data alat tes demo (DISC 24 soal, 77 norma, 4 interpretasi). |

## Aturan wajib kontributor

Aturan lengkap dibaca otomatis oleh Claude Code dari `.claude/rules/`; ringkasnya berlaku juga untuk manusia:

1. **Maksimal 200 baris per file** — lebih dari itu, refactor (Actions/Services/trait/partial).
2. **Tanpa komentar** — kecuali PHPDoc kontrak tipe. Nama yang jelas menggantikan komentar.
3. **UI nol kontrol native browser** — pakai komponen Filament/modal kustom; semua teks Indonesia natural.
4. **Dokumentasi terbaru dulu** — jangan menulis API framework dari ingatan.
5. Sebelum selesai: `php artisan test --compact` hijau penuh, `vendor/bin/pint --dirty`, `npm run build`.

## Alur kontribusi (repo ini adalah fork)

1. Sinkronkan fork dengan repo utama (`git remote add upstream <url-repo-utama>` → `git fetch upstream` → rebase `main`).
2. Buat branch per item backlog: `feat/T2-big-five`, `fix/runner-timer`, dst.
3. Kerjakan satu item `BACKLOG.md` per branch, penuhi **DEFINITION OF DONE** di file yang sama.
4. Commit gaya Conventional Commits, lalu buka PR ke repo utama dengan bukti verifikasi (hasil test + screenshot).

## Bekerja dengan Claude Code (orchestrator)

Proyek ini disiapkan agar pengembangan bisa berjalan otonom dan tahan putus sesi:

- Jalankan **`/orchestrator`** — Claude membaca `.claude/orchestrator/STATE.md` + `BACKLOG.md`, mengerjakan item teratas dalam siklus *rencana → implementasi → verifikasi → commit → catat*, lalu lanjut ke item berikutnya.
- **Kena session limit?** Buka sesi baru dan jalankan `/orchestrator` lagi. State selalu ditulis ke disk sebelum dan sesudah tiap fase, jadi pekerjaan berlanjut dari checkpoint terakhir — hook `SessionStart` bahkan menyuntikkan state itu otomatis ke tiap sesi baru.
- Sub-agent siap pakai: `psy-worker` (implementor terisolasi) dan `psy-verifier` (test + verifikasi browser via Chrome DevTools MCP).
- Konteks arsitektur lintas sesi: `.claude/memory/PROGRESS.md`.

## Testing

```bash
php artisan test --compact                 # seluruh suite (wajib hijau sebelum PR)
php artisan test --compact --filter=Nama   # satu test
```

Setiap alat tes baru wajib punya feature test yang membuktikan angka skoringnya (raw → norma → interpretasi), bukan sekadar halaman terbuka.
