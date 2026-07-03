@php
    $langkahPengerjaan = [
        [
            'judul' => 'Terima kode undangan',
            'deskripsi' => 'Penyelenggara tes membagikan kode undangan untuk Anda. Daftar akun, masukkan kodenya, dan tes siap dikerjakan.',
        ],
        [
            'judul' => 'Kerjakan tes',
            'deskripsi' => 'Jawab soal satu per satu dengan tampilan yang nyaman. Progres tersimpan otomatis, jadi tidak perlu khawatir terputus.',
        ],
        [
            'judul' => 'Lihat hasil',
            'deskripsi' => 'Selesai mengerjakan, hasil dan interpretasinya langsung tersedia di dashboard Anda — tanpa menunggu.',
        ],
    ];
@endphp

<section class="mx-auto w-full max-w-6xl px-4 py-20 sm:px-6 sm:py-24 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl dark:text-white">
            Cara kerjanya simpel
        </h2>
        <p class="mt-4 text-base leading-relaxed text-slate-600 dark:text-slate-400">
            Tiga langkah saja — dari menerima undangan sampai membaca hasil tes Anda.
        </p>
    </div>

    <ol class="mt-14 grid gap-10 sm:grid-cols-3 sm:gap-8">
        @foreach ($langkahPengerjaan as $langkah)
            <li class="relative text-center sm:text-start">
                <span class="mx-auto flex size-12 items-center justify-center rounded-2xl bg-emerald-600 text-lg font-bold text-white shadow-sm sm:mx-0 dark:bg-emerald-500 dark:text-emerald-950">
                    {{ $loop->iteration }}
                </span>
                <h3 class="mt-5 text-lg font-semibold text-slate-900 dark:text-white">{{ $langkah['judul'] }}</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $langkah['deskripsi'] }}</p>
            </li>
        @endforeach
    </ol>

    <div class="mt-16 rounded-3xl bg-emerald-600 px-6 py-12 text-center shadow-sm sm:px-12 dark:bg-emerald-500/15 dark:ring-1 dark:ring-emerald-500/30">
        <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl dark:text-emerald-300">
            Siap mengenal diri lebih dalam?
        </h2>
        <p class="mx-auto mt-3 max-w-xl text-base leading-relaxed text-emerald-100 dark:text-slate-400">
            Buat akun gratis, masukkan kode undangan Anda, dan mulai kerjakan tesnya hari ini.
        </p>
        <a
            href="{{ url('/participant/register') }}"
            class="mt-8 inline-block rounded-xl bg-white px-6 py-3 text-base font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50 dark:bg-emerald-500 dark:text-emerald-950 dark:hover:bg-emerald-400"
        >
            Daftar Sekarang
        </a>
    </div>
</section>
