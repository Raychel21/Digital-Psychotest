@php
    $logicCount = $questions->filter(fn ($question): bool => ($question->logic['visible_if'] ?? null) !== null)->count();
    $variablesCount = count($assessment->logic['variables'] ?? []);
@endphp

<div class="flex flex-col gap-4 lg:sticky lg:top-20">
    <x-filament::section compact>
        <x-slot name="heading">Ringkasan</x-slot>

        <dl class="space-y-2 text-sm">
            <div class="flex items-center justify-between">
                <dt class="text-gray-500 dark:text-gray-400">Jumlah soal</dt>
                <dd class="font-semibold text-gray-900 dark:text-white">{{ $questions->count() }}</dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-gray-500 dark:text-gray-400">Soal berlogika</dt>
                <dd class="font-semibold text-gray-900 dark:text-white">{{ $logicCount }}</dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-gray-500 dark:text-gray-400">Variabel kustom</dt>
                <dd class="font-semibold text-gray-900 dark:text-white">{{ $variablesCount }}</dd>
            </div>
        </dl>
    </x-filament::section>

    <x-filament::section compact>
        <x-slot name="heading">Dimensi</x-slot>

        @if (empty($dimensionOptions))
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Belum ada dimensi. Kelola dimensi lewat halaman edit asesmen agar skor opsi bisa diatur.
            </p>
        @else
            <div class="flex flex-wrap gap-1.5">
                @foreach ($dimensionOptions as $code => $label)
                    <x-filament::badge color="gray" size="sm" :tooltip="$label">{{ $code }}</x-filament::badge>
                @endforeach
            </div>
        @endif
    </x-filament::section>

    <x-filament::section compact>
        <x-slot name="heading">Logika & rumus</x-slot>
        <x-slot name="description">Rumus dihitung dari skor hasil (raw/norm) setelah peserta selesai.</x-slot>

        <x-filament::button
            color="gray"
            icon="heroicon-o-variable"
            class="w-full"
            x-on:click="$dispatch('open-modal', { id: 'builder-variables' })"
        >
            Variabel & Rumus
        </x-filament::button>
    </x-filament::section>

    <p class="px-1 text-xs leading-relaxed text-gray-400 dark:text-gray-500">
        Semua perubahan tersimpan otomatis. Seret ikon <span class="font-semibold">≡</span> untuk mengurutkan soal maupun opsi.
    </p>
</div>
