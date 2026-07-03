<x-filament-panels::page>
    @php
        $question = $this->currentQuestion();
        $total = $this->visibleQuestions()->count();
        $answered = $this->answeredCount();
        $number = $this->index + 1;
        $progress = $total > 0 ? (int) round($answered / $total * 100) : 0;
        $expiresAtMs = $this->expiresAtMs();
    @endphp

    @vite('resources/js/runner.js')

    {{-- Sisa waktu (countdown di klien; server tetap sumber kebenaran) --}}
    @if ($expiresAtMs !== null)
        <div
            class="sticky top-16 z-10"
            x-data="{
                deadline: {{ $expiresAtMs }},
                remaining: 0,
                reported: false,
                tick() {
                    this.remaining = Math.max(0, Math.ceil((this.deadline - Date.now()) / 1000))

                    if (this.remaining <= 0 && ! this.reported) {
                        this.reported = true
                        $wire.forceSubmitExpired()
                    }
                },
                display() {
                    const minutes = String(Math.floor(this.remaining / 60)).padStart(2, '0')
                    const seconds = String(this.remaining % 60).padStart(2, '0')

                    return `${minutes}:${seconds}`
                },
            }"
            x-init="tick(); setInterval(() => tick(), 1000)"
        >
            <div
                class="flex items-center justify-between gap-4 rounded-xl border border-gray-200 bg-white/95 px-4 py-2.5 shadow-sm backdrop-blur dark:border-gray-700 dark:bg-gray-900/95"
            >
                <span class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                    <x-filament::icon icon="heroicon-o-clock" class="h-4 w-4 text-gray-400" />
                    Sisa waktu
                </span>
                <span
                    class="font-mono text-base font-semibold tabular-nums"
                    :class="remaining <= 60 ? 'text-danger-600 dark:text-danger-400' : 'text-gray-900 dark:text-white'"
                    x-text="display()"
                >--:--</span>
            </div>
        </div>
    @endif

    {{-- Progres pengerjaan --}}
    <x-filament::section>
        <div class="flex items-center justify-between gap-4">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                Terjawab {{ $answered }} dari {{ $total }} soal
            </span>
            <span class="text-sm font-semibold text-primary-600 dark:text-primary-400">{{ $progress }}%</span>
        </div>
        <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
            <div class="h-2 rounded-full bg-primary-600 transition-all duration-300" style="width: {{ $progress }}%"></div>
        </div>
    </x-filament::section>

    {{-- Instruksi asesmen --}}
    @if (filled($this->attempt->assessment->instructions))
        <x-filament::section collapsible collapsed icon="heroicon-o-information-circle">
            <x-slot name="heading">Instruksi Pengerjaan</x-slot>

            <div class="prose prose-sm max-w-none text-gray-700 dark:prose-invert dark:text-gray-200">
                {!! nl2br(e($this->attempt->assessment->instructions)) !!}
            </div>
        </x-filament::section>
    @endif

    {{-- Soal aktif --}}
    @if ($question)
        <x-filament::section>
            <x-slot name="heading">Soal {{ $number }} dari {{ $total }}</x-slot>

            @if ($question->required)
                <x-slot name="description">Wajib dijawab</x-slot>
            @endif

            <div class="space-y-6">
                @if (filled($question->image_path))
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($question->image_path) }}"
                        alt="Gambar soal {{ $number }}"
                        class="max-h-72 w-auto max-w-full rounded-xl border border-gray-200 object-contain dark:border-gray-700"
                    />
                @endif

                <p class="text-base font-medium text-gray-900 dark:text-white">{{ $question->text }}</p>

                @include($this->questionPartial($question), ['question' => $question])
            </div>
        </x-filament::section>

        {{-- Navigasi --}}
        <div class="flex items-center justify-between gap-3">
            <x-filament::button
                color="gray"
                icon="heroicon-o-arrow-left"
                wire:click="goToPrevious"
                :disabled="$this->index === 0"
            >
                Kembali
            </x-filament::button>

            @if ($number < $total)
                <x-filament::button
                    icon="heroicon-o-arrow-right"
                    icon-position="after"
                    wire:click="goToNext"
                >
                    Lanjut
                </x-filament::button>
            @else
                <x-filament::button
                    color="success"
                    icon="heroicon-o-paper-airplane"
                    wire:click="submit"
                    wire:confirm="Yakin ingin mengumpulkan jawaban? Jawaban tidak dapat diubah setelah dikumpulkan."
                >
                    Kumpulkan Jawaban
                </x-filament::button>
            @endif
        </div>
    @else
        <x-filament::section>
            <p class="text-sm text-gray-600 dark:text-gray-300">Asesmen ini belum memiliki soal.</p>
        </x-filament::section>
    @endif
</x-filament-panels::page>
