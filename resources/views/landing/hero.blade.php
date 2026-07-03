<section class="relative overflow-hidden">
    {{-- Latar dekoratif: gradasi lembut, tanpa aset eksternal --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 -z-10 flex justify-center">
        <div class="h-72 w-[36rem] rounded-full bg-emerald-200/40 blur-3xl sm:h-96 sm:w-[56rem] dark:bg-emerald-500/10"></div>
    </div>

    <div class="mx-auto w-full max-w-6xl px-4 pt-16 pb-20 text-center sm:px-6 sm:pt-24 sm:pb-28 lg:px-8">
        <p class="mx-auto inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-1.5 text-sm font-medium text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-300">
            <span class="size-1.5 rounded-full bg-emerald-500"></span>
            Platform tes psikologi online
        </p>

        <h1 class="mx-auto mt-6 max-w-3xl text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl dark:text-white">
            Kenali potensi diri lewat tes psikologi yang
            <span class="text-emerald-600 dark:text-emerald-400">tepercaya</span>
        </h1>

        <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-slate-600 sm:text-lg dark:text-slate-400">
            Psychotest menyediakan alat tes yang lengkap — dari DISC sampai skala Likert —
            dengan penilaian berstandar dan hasil yang bisa langsung Anda lihat begitu tes selesai.
        </p>

        <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row sm:gap-4">
            <a
                href="{{ url('/participant/register') }}"
                class="w-full rounded-xl bg-emerald-600 px-6 py-3 text-base font-semibold text-white shadow-sm transition hover:bg-emerald-500 sm:w-auto dark:bg-emerald-500 dark:text-emerald-950 dark:hover:bg-emerald-400"
            >
                Daftar Sekarang
            </a>
            <a
                href="{{ route('login') }}"
                class="w-full rounded-xl border border-slate-300 px-6 py-3 text-base font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-slate-50 sm:w-auto dark:border-slate-700 dark:text-slate-300 dark:hover:border-slate-600 dark:hover:bg-slate-900"
            >
                Sudah punya kode? Masuk
            </a>
        </div>

        <ul class="mx-auto mt-12 flex max-w-2xl flex-col items-center justify-center gap-3 text-sm font-medium text-slate-600 sm:flex-row sm:gap-8 dark:text-slate-400">
            @foreach (['Alat tes lengkap', 'Penilaian berstandar', 'Hasil instan'] as $poin)
                <li class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 text-emerald-600 dark:text-emerald-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    {{ $poin }}
                </li>
            @endforeach
        </ul>
    </div>
</section>
