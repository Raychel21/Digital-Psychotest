---
paths:
  - "resources/**"
  - "app/Filament/**"
---

# UI Konsisten — Nol Kontrol Native Browser

- DILARANG memakai rupa native browser: `<select>` polos, spinner `<input type=number>`, `confirm()`/`alert()`/`prompt()`, `wire:confirm`, date picker native, file input terlihat.
- Pengganti wajib:
  - Dropdown/isian → `x-filament::input.wrapper` + `x-filament::input` / `x-filament::input.select`
  - Konfirmasi destruktif → `x-filament::modal` (pola: satu modal global per halaman, Alpine `pendingId`, event `*.window`)
  - Radio/checkbox → cukup elemen native berkelas; `resources/css/chrome.css` sudah meng-custom penuh (warna via `text-*` → `currentColor`)
  - Select/DatePicker form Filament → sudah `native(false)` global via `AppServiceProvider`; jangan di-override ke native
- Scrollbar, `::selection`, focus ring, autofill: sudah diatur `chrome.css` (di-`@layer base` supaya utility menang). Jangan menduplikasi per-halaman.
- Pengecualian yang disadari: select "per halaman" milik paginator vendor Filament (kotak sudah bergaya tema; hanya popup list yang OS-level). Jangan override view vendor hanya untuk ini.
- Semua teks UI bahasa Indonesia natural (tidak kaku). Terjemahan vendor yang kaku di-override lewat `lang/vendor/...`. Format tanggal `j M Y, H:i`.
- Komponen Alpine yang didaftarkan modul Vite WAJIB tahan navigasi SPA: register langsung bila `window.Alpine` ada + `destroyTree`/`initTree` ulang elemen yang terlanjur dirender (lihat `resources/js/builder.js` dan `runner.js`).
- Selesai mengubah UI: `npm run build`, lalu verifikasi visual via Chrome DevTools MCP (screenshot + console bersih) sebelum dianggap selesai.
