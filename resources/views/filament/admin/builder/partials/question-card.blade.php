@php
    $usesOptions = $question->type->usesOptions();
    $hasLogic = ($question->logic['visible_if'] ?? null) !== null;
@endphp

<div
    wire:key="question-{{ $question->id }}"
    data-sortable-id="{{ $question->id }}"
    class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
>
    {{-- Kepala kartu --}}
    <div class="flex flex-wrap items-center gap-2 border-b border-gray-100 px-4 py-2.5 dark:border-white/10">
        <button
            type="button"
            class="builder-drag-handle -ms-1 cursor-grab rounded p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
            title="Seret untuk mengurutkan"
        >
            <x-filament::icon icon="heroicon-m-bars-3" class="h-5 w-5" />
        </button>

        <span class="text-xs font-semibold uppercase tracking-wide text-gray-400">Soal {{ $question->sort }}</span>

        <x-filament::badge color="info" size="sm">{{ $question->type->getLabel() }}</x-filament::badge>

        @if ($hasLogic)
            <x-filament::badge color="warning" size="sm" icon="heroicon-m-code-bracket">Logika aktif</x-filament::badge>
        @endif

        <div class="ms-auto flex items-center gap-1.5">
            <label class="me-1 flex cursor-pointer items-center gap-1.5 text-xs font-medium text-gray-500 dark:text-gray-400">
                <input
                    type="checkbox"
                    @checked($question->required)
                    x-on:change="$wire.updateQuestion({{ $question->id }}, { required: $event.target.checked })"
                    class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:border-white/20 dark:bg-gray-800"
                />
                Wajib
            </label>

            <x-filament::icon-button
                icon="heroicon-o-code-bracket-square"
                color="gray"
                label="Logika tampil"
                tooltip="Logika tampil"
                x-on:click="$dispatch('open-modal', { id: 'builder-logic', questionId: {{ $question->id }} })"
            />

            <label class="cursor-pointer rounded-lg p-2 text-gray-400 transition hover:text-primary-500" title="Tambahkan gambar soal">
                <input type="file" accept="image/*" class="sr-only" wire:model="uploads.question-{{ $question->id }}" />
                <x-filament::icon icon="heroicon-o-photo" class="h-5 w-5" />
            </label>

            <x-filament::icon-button
                icon="heroicon-o-document-duplicate"
                color="gray"
                label="Duplikat"
                tooltip="Duplikat"
                wire:click="duplicateQuestion({{ $question->id }})"
            />

            <x-filament::icon-button
                icon="heroicon-o-trash"
                color="danger"
                label="Hapus"
                tooltip="Hapus"
                x-on:click="$dispatch('builder-hapus-soal', { questionId: {{ $question->id }} })"
            />
        </div>
    </div>

    {{-- Isi kartu --}}
    <div class="space-y-4 px-4 py-4">
        <textarea
            rows="1"
            placeholder="Tulis pertanyaan di sini..."
            class="w-full resize-none overflow-hidden border-0 bg-transparent p-0 text-base font-medium text-gray-900 placeholder:text-gray-400 focus:ring-0 dark:text-white"
            x-data
            x-init="$nextTick(() => { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px' })"
            x-on:input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
            x-on:change="$wire.updateQuestion({{ $question->id }}, { text: $event.target.value })"
        >{{ $question->text }}</textarea>

        <div wire:loading wire:target="uploads.question-{{ $question->id }}" class="text-xs text-gray-500">
            Mengunggah gambar...
        </div>

        @if (filled($question->image_path))
            <div class="relative inline-block">
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($question->image_path) }}"
                    alt="Gambar soal"
                    class="max-h-56 rounded-lg object-contain ring-1 ring-gray-950/5 dark:ring-white/10"
                />
                <button
                    type="button"
                    wire:click="removeQuestionImage({{ $question->id }})"
                    class="absolute -end-2 -top-2 rounded-full bg-gray-900 p-1 text-white shadow hover:bg-danger-600"
                    title="Hapus gambar"
                >
                    <x-filament::icon icon="heroicon-m-x-mark" class="h-3.5 w-3.5" />
                </button>
            </div>
        @endif

        @if ($usesOptions)
            <div
                class="flex flex-col gap-2"
                x-data="builderSortable({ handle: '.option-drag-handle', onSort: (ids) => $wire.reorderOptions({{ $question->id }}, ids) })"
            >
                @foreach ($question->options as $option)
                    @include('filament.admin.builder.partials.option-row', [
                        'option' => $option,
                        'question' => $question,
                        'dimensionOptions' => $dimensionOptions,
                    ])
                @endforeach
            </div>

            <button
                type="button"
                wire:click="addOption({{ $question->id }})"
                class="flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400"
            >
                <x-filament::icon icon="heroicon-m-plus" class="h-4 w-4" />
                Tambah opsi
            </button>
        @else
            <p class="rounded-lg bg-gray-50 px-3 py-2 text-sm text-gray-500 dark:bg-white/5 dark:text-gray-400">
                Peserta akan menjawab dengan isian teks bebas. Jawaban tidak dinilai.
            </p>
        @endif
    </div>
</div>
