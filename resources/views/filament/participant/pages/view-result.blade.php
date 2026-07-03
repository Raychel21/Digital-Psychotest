<x-filament-panels::page>
    @php
        $result = $this->attempt->result;
        $summary = $result->summary ?? [];
        $normScores = $result->norm_scores ?? [];
        $dimensionNames = $this->dimensionNames();
        $primaryDimension = $summary['primary_dimension'] ?? null;
        $interpretations = $summary['interpretations'] ?? [];
    @endphp

    {{-- Ringkasan --}}
    <x-filament::section icon="heroicon-o-sparkles">
        <x-slot name="heading">Ringkasan Hasil</x-slot>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-primary-100 text-2xl font-bold text-primary-700 dark:bg-primary-900 dark:text-primary-300">
                {{ $primaryDimension ?? '—' }}
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Dimensi dominan</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $primaryDimension ? ($dimensionNames[$primaryDimension] ?? $primaryDimension) : 'Tidak tersedia' }}
                </p>
                @if (filled($summary['primary_scale'] ?? null))
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Berdasarkan skala: {{ $this->scaleLabel($summary['primary_scale']) }}
                    </p>
                @endif
            </div>
        </div>
    </x-filament::section>

    {{-- Interpretasi --}}
    @if ($interpretations !== [])
        <x-filament::section icon="heroicon-o-light-bulb">
            <x-slot name="heading">Interpretasi</x-slot>

            <div class="space-y-4">
                @foreach ($interpretations as $interpretation)
                    <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <x-filament::badge color="primary">{{ $interpretation['dimension'] ?? '—' }}</x-filament::badge>
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $interpretation['title'] ?? '' }}</h4>
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                            {{ $interpretation['body'] ?? '' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </x-filament::section>
    @endif

    {{-- Skor norma per skala --}}
    @foreach ($normScores as $scale => $dimensionScores)
        <x-filament::section collapsible :collapsed="$scale !== ($summary['primary_scale'] ?? null)">
            <x-slot name="heading">Skor — {{ $this->scaleLabel((string) $scale) }}</x-slot>

            <div class="space-y-3">
                @foreach ($dimensionScores as $code => $value)
                    <div class="flex items-center gap-4">
                        <span class="w-40 shrink-0 truncate text-sm font-medium text-gray-700 dark:text-gray-200">
                            {{ $dimensionNames[$code] ?? $code }}
                        </span>
                        <div class="h-3 flex-1 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                            <div
                                class="h-3 rounded-full {{ $code === $primaryDimension ? 'bg-primary-600' : 'bg-primary-400' }}"
                                style="width: {{ $this->barPercentage($dimensionScores, $value) }}%"
                            ></div>
                        </div>
                        <span class="w-10 shrink-0 text-end text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $value }}
                        </span>
                    </div>
                @endforeach
            </div>
        </x-filament::section>
    @endforeach

    <div>
        <x-filament::button tag="a" color="gray" icon="heroicon-o-arrow-left" :href="\App\Filament\Participant\Pages\MyResults::getUrl()">
            Kembali ke Hasil Saya
        </x-filament::button>
    </div>
</x-filament-panels::page>
