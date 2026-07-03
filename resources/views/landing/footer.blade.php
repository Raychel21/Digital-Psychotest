<footer class="border-t border-slate-200/70 dark:border-slate-800">
    <div class="mx-auto flex w-full max-w-6xl flex-col items-center justify-between gap-4 px-4 py-10 text-center sm:flex-row sm:px-6 sm:text-start lg:px-8">
        <div class="flex items-center gap-2">
            <span class="flex size-7 items-center justify-center rounded-lg bg-emerald-600 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h3l2.25-6 4.5 12 2.25-6h4.5" />
                </svg>
            </span>
            <span class="text-sm font-semibold text-slate-900 dark:text-white">Psychotest</span>
        </div>

        <p class="text-sm text-slate-500 dark:text-slate-400">
            &copy; {{ date('Y') }} Psychotest. Platform tes psikologi online.
        </p>

        <div class="flex items-center gap-4 text-sm font-medium">
            <a href="{{ route('login') }}" class="text-slate-600 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">Masuk</a>
            <a href="{{ url('/participant/register') }}" class="text-emerald-600 transition hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300">Daftar</a>
        </div>
    </div>
</footer>
