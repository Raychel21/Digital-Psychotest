# PROGRESS — Platform Psikotes (Laravel 12 + Filament v5)

> Update terakhir: 2026-07-03 (sesi audit browser). File ini = sumber kebenaran lintas sesi.

## AUDIT BROWSER 2026-07-03 — SELESAI ✓ (Chrome DevTools MCP, semua halaman diuji)
Bug ditemukan & diperbaiki (39 test pass / 466 assertion, pint clean):
1. Login 500: RoleBasedLoginResponse & UnifiedLogoutResponse return type harus
   `RedirectResponse|Redirector` (Livewire). + tests/Feature/UnifiedLoginTest.php (regresi).
2. Builder 500: partial `option-scores.blade.php` HILANG (agent mati) → dibuat.
   Mode most/least = 2 select dimensi; mode KV = Alpine `optionScores` + select dimensi
   (sekaligus menutup backlog Fase 3 #4 validasi kode dimensi).
3. Builder CSS purged: admin theme.css kurang `@source resources/views/filament/admin/**` → fixed + npm run build.
4. Naturalisasi: AssessmentResource label "Alat Tes", kolom Nama/Status/Dibuat.
Terverifikasi via browser: landing, /login, redeem undangan (batch 2 kode), runner most/least
(jawab→persist→progress), submit → hasil (skor D4/I-2/S-2/C4 + interpretasi), Hasil Saya,
ViewAttempt admin, Norma, Undangan, panel developer (Users anti-hapus-diri, stats widget).
Minor belum dikerjakan: format tanggal tabel masih "Jul 2, 2026" (belum lokal id),
dasbor admin polos (hanya widget akun), soal berlogika=0 di demo (logic runtime belum teruji e2e browser).

## Gambaran Produk
Platform tes psikologi online: no-code questionnaire builder (drag-drop + logic blocks),
scoring akurat data-driven (raw → norma → interpretasi), multi-role 3 panel Filament.

## Stack & Keputusan Kunci
- PHP 8.5, Laravel 12, Filament **v5** (SPA mode aktif semua panel), Tailwind v4, SQLite.
- Deps tambahan (approved): npm `sortablejs`, `blockly`; composer `jwadhams/json-logic-php`.
- Skill wajib: `.claude/skills/laravel-filament/references/namespaces.md` (kontrak namespace v5).
- Aturan repo: file ≤200 baris, typed + PHPDoc shapes, logika bisnis di app/Actions & app/Services
  (bukan di Resource/Page), pint --dirty sebelum selesai, PHPUnit (bukan Pest).
- Locale: `id` (APP_LOCALE=id, faker id_ID). UI bahasa Indonesia natural (tidak kaku).

## Arsitektur Domain (semua sudah jadi & hijau)
- Model: Assessment, Dimension, Question, Option, Norm, Interpretation, Attempt, Answer,
  TestResult, Invitation, User (role: developer|administrator|participant via enum UserRole).
- Enum: UserRole, AssessmentStatus, QuestionType (single_choice, multiple_choice, likert,
  most_least, ranking, text), AttemptStatus, NormScale (sum|most|least|change).
- Kontrak Option.scores: choice/likert `{"D":2}`; most_least `{"most":{"D":1},"least":{"S":1}}`.
- Kontrak Answer.payload: `{"option_id"}|{"option_ids"}|{"most_option_id","least_option_id"}|
  {"ordered_option_ids"}|{"text"}`.
- Scoring: RawScoreCalculator (ChoiceScorer, MostLeastScorer, RankingScorer; change=most−least)
  → NormConverter (tabel norms, passthrough bila tak ada) → ResultGenerator (primary via
  settings.primary_scale, interpretasi range-match, variables via LogicEvaluator).
- Logic (Blockly → JsonLogic, evaluasi server json-logic-php):
  - questions.logic = `{"visible_if": <rule>, "workspace": <blockly-state>}`
  - assessments.logic = `{"variables":[{"name","formula","workspace"}]}`
  - Konteks: `answers.<qid>.<field>`; skor: `raw|norm.<scale>.<code>`, `vars.<name>`.
- Timer: assessments.settings.time_limit_minutes; Attempt::expiresAt()/isExpired();
  server = sumber kebenaran (SaveAnswer tolak expired; SubmitAttempt auto-submit parsial).
- Kolom tambahan fase 2: assessments.logic, questions.logic+image_path, options.image_path.

## Panel & Auth
- /admin (indigo): AssessmentResource (+builder), NormResource, InvitationResource (+Generate
  batch → app/Actions/GenerateInvitations), AttemptResource read-only.
- /developer (rose): UserResource (role select, anti hapus-diri), AttemptResource read-only,
  PlatformStatsWidget.
- /participant (emerald): registrasi + login, dashboard widget redeem undangan + lanjutkan,
  TakeTest (slug tes/{attempt}), MyResults (hasil-saya), ViewResult (hasil/{attempt}).
- Login TUNGGAL: route `/login` (named login) → redirect participant/login (satu-satunya form);
  RoleBasedLoginResponse redirect per role; UnifiedLogoutResponse → /login;
  RedirectToUnifiedLogin middleware di authMiddleware admin+developer.
  Binding di AppServiceProvider::register().

## Akun Seed (password semua: `password`)
developer@psychotest.test / admin@psychotest.test / participant@psychotest.test
(+ user manual admin@psychotest.test role developer dari sesi awal — sudah tergantikan seeder).
Demo: Assessment DISC slug `disc` published, 24 soal most_least, 77 norma, 4 interpretasi
(data: database/seeders/data/*.php; sumber legacy git ee0236b).

## Status Test Suite
28 test (27 pass + ExampleTest fail HANYA karena ViteManifestNotFoundException — hilang
setelah `npm run build`). Test: Scoring, Choice, PanelAccess, DiscSeeder, RunnerUpgrade (8).

## FASE 1 — SELESAI ✓
Wipe legacy DISC → fondasi domain → 3 panel → resources semua panel → seeder+factories+tests.

## FASE 2 — SELESAI ✓ (2026-07-03)
Semua item tuntas: fondasi (Ranking, logic, image, timer), /login unified + SPA + locale id,
Runner (ranking drag, gambar, countdown, logic runtime), Builder (canvas drag-drop, 12 Actions,
Blockly blok Indonesia → JsonLogic, gambar soal/opsi, buka via tabel/Edit/"/admin/assessments/
{id}/builder"), Theme (base.css shared + 3 tema, spacing fixes, landing 5 partial, naturalisasi).
Integrasi: npm run build OK (Blockly dynamic import), **35 test pass / 440 assertion**, pint clean.

### Sisa Agent Builder (scope: app/Filament/Resources/Assessments/**, app/Actions/Builder/**,
resources/views/filament/admin/builder/**, resources/js/builder.js + builder/*)
Sudah ada di disk: 12 Actions (Add/Update/Delete/Duplicate/Reorder Question+Option,
SaveQuestionLogic, SaveAssessmentVariables, StoreBuilderImage), BuildAssessment page
(terdaftar 'builder' => route('/{record}/builder')), blade + 6 partials (palette, question-card,
option-row, inspector, logic-modal, variables-modal), JS (sortable.js, scores.js,
blockly/{blocks,generator,loader}.js).
- [ ] tests/Feature/BuilderActionsTest.php (BELUM ADA): AddQuestion, DuplicateQuestion
      (options+scores tercopy), ReorderQuestions persist sort, round-trip questions.logic.
- [ ] Jalankan filter test sampai hijau; php artisan about; pint --dirty.
- [ ] Verifikasi action "Buka Builder" di tabel + Edit page; storage:link ada.

### Sisa Agent Theme (scope: resources/css/**, welcome + resources/views/landing/**,
provider viteTheme-only, app/Filament/Resources/{Norms,Invitations,Attempts}/**,
app/Filament/Developer/**, app/Enums/*)
Sudah ada: 3 theme.css (+ resources/css/base.css shared) ter-register viteTheme di 3 provider;
landing lengkap (welcome 23 baris + landing/{navbar,hero,features,steps,footer}); enum labels
sudah Indonesia (Pengembang/Peserta/Draf/Terbit/...).
- [ ] Audit sisa: naturalisasi label di Norms/Invitations/Attempts/Developer resources
      (cek sudah sejauh mana), spacing audit widget/tabel.
- [ ] php artisan view:cache lalu view:clear (cek compile), pint --dirty, laporan.

### Integrasi (main thread, setelah 2 agent):
- [ ] npm run build (wajib — ExampleTest & tema butuh manifest).
- [ ] php artisan test --compact penuh (target 28+ pass, 0 fail).
- [ ] pint --dirty; route:list smoke 3 panel + /login; migrate:fresh --seed final.
- [ ] Tawarkan commit ke user (belum pernah commit; baseline = ee0236b "first commit").

## FASE 3 — UI KUSTOM TOTAL & KESIAPAN PRODUKSI — SELESAI ✓ (2026-07-03)
Goal: nol UI native browser, siap produksi, seluruh teks Indonesia natural. Terverifikasi
browser end-to-end (redeem kode ke-2 → runner → modal → hasil "Influence"), 39 test/466 pass.
1. Dialog native → modal Filament ✓: runner "Kumpulkan Jawaban" (konfirmasi-kumpulkan) +
   builder "Hapus soal" (modal global builder-hapus-soal, Alpine pendingId, event
   builder-hapus-soal.window). wire:confirm = 0 di codebase.
2. Kontrol native → kustom ✓: option-scores pakai x-filament::input.wrapper+select+input;
   radio/checkbox global appearance-none di chrome.css (currentColor: most hijau, least merah
   via text-success/danger-600 — checked rule perlu :root.dark variant utk menang specificity).
3. resources/css/chrome.css (BARU, @layer base agar utilities menang) diimpor base.css +
   app.css: scrollbar tipis, ::selection, radio/checkbox, no number-spinner, autofill fix;
   app.css + focus-visible ring landing.
4. Bahasa ✓: lang/id/{validation,auth,passwords,pagination}.php (natural);
   lang/vendor/filament-panels/id/auth/pages/login.php override "Kredensial..." kaku →
   "Email atau kata sandi tidak cocok...". Tanggal: AppServiceProvider
   Table::configureUsing + Schema::configureUsing defaultDateTimeDisplayFormat('j M Y, H:i').
5. Produksi ✓: InitialsAvatarProvider (data-URI SVG, ganti ui-avatars.com) di 3 panel provider,
   public/favicon.svg (+welcome head), AdminStatsWidget (app/Filament/Widgets, sort 2).
Catatan minor: klik "Mulai Tes" <1 dtk setelah page load = native GET fallback (Livewire belum
init); manusia tak kena, input kini ber-name/id. Blockly canvas tetap putih (scrollbar internal
Blockly, biarkan).
Hotfix 03070e1: masuk builder via SPA (wire:navigate) → Alpine init DOM sebelum module builder.js
eksekusi → "addRow/builderSortable is not defined". Fix = pola runner.js: register langsung bila
Alpine sudah jalan + destroyTree/initTree komponen builder terluar yang terlanjur dirender.
Sisa kosmetik: warning "not defined" sekali di console saat first paint SPA (sebelum re-init) —
fungsional aman. Misteri "25 soal" kemarin = soal percobaan sesi lama (id 25-27) yang terhapus.

## FASE 4 — BACKLOG (disetujui user, belum dikerjakan)
1. Modul Kraepelin/Pauli: grid angka ber-timer per kolom, autoscroll, tempo kerja, grafik.
2. Modul IST/CFIT: subtest bergambar penuh, timer per subtest/section.
3. Sections/page-break (prasyarat modul di atas), matrix presentasi (grid Likert).
4. Export hasil PDF, grafik profil (chart) di halaman hasil.
(Catatan: validasi ketat kode dimensi sudah selesai lewat select di option-scores, 2026-07-03.)

## Cara Resume Sub-agent
Runner/Builder/Theme = general-purpose background agents. Bila mati kena limit:
cek disk dulu (scope masing-masing) — seringnya kerjaan hampir selesai; resume via
SendMessage ke agent-id yang sama (context utuh) berisi checklist sisa, atau spawn baru
dengan prompt = spec asli + "sudah ada di disk: X; kerjakan hanya sisa: Y".
JANGAN suruh agent `npm run build` / `migrate:fresh` (jatah integrator).
