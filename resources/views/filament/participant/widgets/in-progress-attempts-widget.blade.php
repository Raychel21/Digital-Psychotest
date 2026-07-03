<x-filament-widgets::widget>
    <x-filament::section icon="heroicon-o-clock">
        <x-slot name="heading">Tes Sedang Berjalan</x-slot>
        <x-slot name="description">Lanjutkan pengerjaan tes yang belum selesai.</x-slot>

        <div class="space-y-3">
            @foreach ($attempts as $attempt)
                @php
                    $total = $attempt->assessment?->questions_count ?? 0;
                    $progress = $total > 0 ? (int) round($attempt->answers_count / $total * 100) : 0;
                @endphp

                <div class="flex flex-col gap-3 rounded-lg border border-gray-200 p-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-700">
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-medium text-gray-900 dark:text-white">
                            {{ $attempt->assessment?->name ?? '—' }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Dimulai {{ $attempt->started_at?->translatedFormat('d M Y H:i') }}
                            &middot; {{ $attempt->answers_count }} / {{ $total }} soal terjawab
                        </p>
                        <div class="mt-2 h-1.5 w-full max-w-xs overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                            <div class="h-1.5 rounded-full bg-primary-600" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>

                    <x-filament::button
                        tag="a"
                        size="sm"
                        icon="heroicon-o-play"
                        :href="\App\Filament\Participant\Pages\TakeTest::getUrl(['attempt' => $attempt])"
                    >
                        Lanjutkan
                    </x-filament::button>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
