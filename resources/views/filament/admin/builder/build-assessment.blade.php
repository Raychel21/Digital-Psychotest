<x-filament-panels::page>
    @vite('resources/js/builder.js')

    @php
        $assessment = $this->getAssessment();
        $questions = $this->questions();
        $dimensionOptions = $this->dimensionOptions();
    @endphp

    <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-[15rem_minmax(0,1fr)_17rem]">
        {{-- Kiri: palet tipe soal --}}
        @include('filament.admin.builder.partials.palette')

        {{-- Tengah: kanvas soal --}}
        <div
            class="flex min-w-0 flex-col gap-4"
            x-data="builderSortable({ handle: '.builder-drag-handle', onSort: (ids) => $wire.reorderQuestions(ids) })"
        >
            @forelse ($questions as $question)
                @include('filament.admin.builder.partials.question-card', [
                    'question' => $question,
                    'dimensionOptions' => $dimensionOptions,
                ])
            @empty
                <x-filament::section>
                    <div class="flex flex-col items-center gap-2 py-10 text-center">
                        <x-filament::icon icon="heroicon-o-squares-plus" class="h-10 w-10 text-gray-400" />
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200">Belum ada soal.</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Pilih tipe soal di panel kiri untuk mulai menyusun asesmen.
                        </p>
                    </div>
                </x-filament::section>
            @endforelse
        </div>

        {{-- Kanan: inspector --}}
        @include('filament.admin.builder.partials.inspector', [
            'assessment' => $assessment,
            'questions' => $questions,
            'dimensionOptions' => $dimensionOptions,
        ])
    </div>

    @include('filament.admin.builder.partials.logic-modal')
    @include('filament.admin.builder.partials.variables-modal')

    {{-- Indikator simpan otomatis --}}
    <div
        x-data="{ visible: false, timer: null }"
        x-on:builder-saved.window="visible = true; clearTimeout(timer); timer = setTimeout(() => visible = false, 2000)"
        x-show="visible"
        x-transition.opacity.duration.300ms
        x-cloak
        class="fixed bottom-6 right-6 z-40 flex items-center gap-2 rounded-full bg-gray-900/90 px-4 py-2 text-sm font-medium text-white shadow-lg dark:bg-white/90 dark:text-gray-900"
    >
        <x-filament::icon icon="heroicon-m-check-circle" class="h-4 w-4 text-success-400" />
        Tersimpan otomatis
    </div>
</x-filament-panels::page>
