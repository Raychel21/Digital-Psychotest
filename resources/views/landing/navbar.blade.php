<header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/85 backdrop-blur-md dark:border-slate-800 dark:bg-slate-950/85">
    <nav class="mx-auto flex h-16 w-full max-w-6xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <span class="flex size-9 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-sm">
                {{-- Ikon denyut: representasi asesmen psikologi --}}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h3l2.25-6 4.5 12 2.25-6h4.5" />
                </svg>
            </span>
            <span class="text-lg font-semibold tracking-tight text-slate-900 dark:text-white">Psychotest</span>
        </a>

        <div class="flex items-center gap-2 sm:gap-3">
            <a
                href="{{ route('login') }}"
                class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 hover:text-slate-900 sm:px-4 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white"
            >
                Masuk
            </a>
            <a
                href="{{ url('/participant/register') }}"
                class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500 sm:px-4 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:text-emerald-950"
            >
                Daftar
            </a>
        </div>
    </nav>
</header>
