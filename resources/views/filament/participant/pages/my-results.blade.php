<x-filament-panels::page>
    @php
        $attempts = $this->attempts();
    @endphp

    @if ($attempts->isEmpty())
        <x-filament::section>
            <div class="flex flex-col items-center gap-2 py-8 text-center">
                <x-filament::icon icon="heroicon-o-clipboard-document-list" class="h-10 w-10 text-gray-400" />
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Anda belum pernah mengerjakan tes. Masukkan kode undangan di Dasbor untuk memulai.
                </p>
                <x-filament::button tag="a" :href="\Filament\Pages\Dashboard::getUrl()" color="gray">
                    Ke Dasbor
                </x-filament::button>
            </div>
        </x-filament::section>
    @else
        <x-filament::section>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left dark:border-gray-700">
                            <th class="py-2 pe-4 font-medium text-gray-700 dark:text-gray-200">Asesmen</th>
                            <th class="px-4 py-2 font-medium text-gray-700 dark:text-gray-200">Status</th>
                            <th class="px-4 py-2 font-medium text-gray-700 dark:text-gray-200">Progres</th>
                            <th class="px-4 py-2 font-medium text-gray-700 dark:text-gray-200">Dimulai</th>
                            <th class="px-4 py-2 font-medium text-gray-700 dark:text-gray-200">Selesai</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attempts as $attempt)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="py-3 pe-4 font-medium text-gray-900 dark:text-white">
                                    {{ $attempt->assessment?->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    <x-filament::badge :color="$attempt->status->getColor()">
                                        {{ $attempt->status->getLabel() }}
                                    </x-filament::badge>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                    {{ $attempt->answers_count }} / {{ $attempt->assessment?->questions_count ?? 0 }} soal
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                    {{ $attempt->started_at?->translatedFormat('d M Y H:i') ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                    {{ $attempt->completed_at?->translatedFormat('d M Y H:i') ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-end">
                                    @if ($attempt->status === \App\Enums\AttemptStatus::InProgress)
                                        <x-filament::button
                                            tag="a"
                                            size="sm"
                                            icon="heroicon-o-play"
                                            :href="\App\Filament\Participant\Pages\TakeTest::getUrl(['attempt' => $attempt])"
                                        >
                                            Lanjutkan
                                        </x-filament::button>
                                    @elseif ($attempt->isCompleted() && $attempt->result)
                                        <x-filament::button
                                            tag="a"
                                            size="sm"
                                            color="gray"
                                            icon="heroicon-o-eye"
                                            :href="\App\Filament\Participant\Pages\ViewResult::getUrl(['attempt' => $attempt])"
                                        >
                                            Lihat Hasil
                                        </x-filament::button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    @endif
</x-filament-panels::page>
