@php
    $fiturUnggulan = [
        [
            'judul' => 'Builder soal tanpa koding',
            'deskripsi' => 'Susun alat tes lengkap dengan aturan skoringnya langsung dari browser. Tidak perlu menyentuh satu baris kode pun.',
            'ikon' => 'M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z',
        ],
        [
            'judul' => 'Beragam jenis alat tes',
            'deskripsi' => 'DISC, skala Likert, ranking, sampai forced-choice — semua format soal yang umum dipakai sudah tersedia.',
            'ikon' => 'M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z',
        ],
        [
            'judul' => 'Skoring & norma akurat',
            'deskripsi' => 'Jawaban dinilai otomatis mengikuti norma penilaian yang Anda tetapkan — konsisten untuk semua peserta.',
            'ikon' => 'M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z',
        ],
        [
            'judul' => 'Hasil & interpretasi otomatis',
            'deskripsi' => 'Begitu tes selesai, hasil beserta interpretasinya langsung tersedia. Tidak perlu menunggu penilaian manual.',
            'ikon' => 'M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z',
        ],
    ];
@endphp

<section class="border-y border-slate-200/70 bg-slate-50 dark:border-slate-800 dark:bg-slate-900/40">
    <div class="mx-auto w-full max-w-6xl px-4 py-20 sm:px-6 sm:py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
                Semua yang dibutuhkan untuk tes psikologi
            </h2>
            <p class="mt-4 text-base leading-relaxed text-slate-600 dark:text-slate-400">
                Dari menyusun soal sampai membaca hasil — satu platform yang merapikan seluruh prosesnya.
            </p>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($fiturUnggulan as $fitur)
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 transition hover:shadow-md dark:bg-slate-900 dark:ring-slate-800">
                    <span class="flex size-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $fitur['ikon'] }}" />
                        </svg>
                    </span>
                    <h3 class="mt-5 text-base font-semibold text-slate-900 dark:text-white">{{ $fitur['judul'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $fitur['deskripsi'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
