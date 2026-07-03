@AGENTS.md

# Orkestrasi & Kelanjutan Antar Sesi

- State pekerjaan lintas sesi ada di `.claude/orchestrator/STATE.md` (disuntik otomatis tiap sesi via hook). Bila diminta "lanjutkan" atau sesi baru tanpa instruksi spesifik, jalankan skill `/orchestrator`.
- Aturan wajib pola kode ada di `.claude/rules/` (batas 200 baris, tanpa komentar, dokumentasi terbaru, /find-skills, UI non-native).
- Konteks arsitektur lengkap: `.claude/memory/PROGRESS.md`.