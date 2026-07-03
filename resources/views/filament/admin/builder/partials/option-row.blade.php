@php
    use App\Filament\Resources\Assessments\Support\OptionScoresMapper;

    $isScored = $question->type->isScored();
@endphp

<div
    wire:key="option-{{ $option->id }}"
    data-sortable-id="{{ $option->id }}"
    class="rounded-lg border border-gray-200 bg-gray-50/50 dark:border-white/10 dark:bg-white/5"
    x-data="{ showScores: false }"
>
    <div class="flex items-center gap-2 px-2.5 py-1.5">
        <button
            type="button"
            class="option-drag-handle cursor-grab rounded p-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
            title="Seret untuk mengurutkan"
        >
            <x-filament::icon icon="heroicon-m-bars-2" class="h-4 w-4" />
        </button>

        <input
            type="text"
            value="{{ $option->label }}"
            placeholder="Teks opsi"
            x-on:change="$wire.updateOption({{ $option->id }}, { label: $event.target.value })"
            class="min-w-0 flex-1 border-0 bg-transparent p-1 text-sm text-gray-900 placeholder:text-gray-400 focus:ring-0 dark:text-white"
        />

        <label class="cursor-pointer p-1 text-gray-400 transition hover:text-primary-500" title="Tambahkan gambar opsi">
            <input type="file" accept="image/*" class="sr-only" wire:model="uploads.option-{{ $option->id }}" />
            <x-filament::icon icon="heroicon-o-photo" class="h-4 w-4" />
        </label>

        @if ($isScored)
            <button
                type="button"
                x-on:click="showScores = ! showScores"
                class="flex items-center gap-1 rounded-md px-1.5 py-1 text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/10"
            >
                <x-filament::icon icon="heroicon-m-calculator" class="h-3.5 w-3.5" />
                Skor
                <x-filament::icon
                    icon="heroicon-m-chevron-down"
                    class="h-3 w-3 transition-transform"
                    x-bind:class="showScores && 'rotate-180'"
                />
            </button>
        @endif

        <button
            type="button"
            wire:click="deleteOption({{ $option->id }})"
            class="p-1 text-gray-400 transition hover:text-danger-500"
            title="Hapus opsi"
        >
            <x-filament::icon icon="heroicon-m-x-mark" class="h-4 w-4" />
        </button>
    </div>

    <div wire:loading wire:target="uploads.option-{{ $option->id }}" class="px-3 pb-2 text-xs text-gray-500">
        Mengunggah gambar...
    </div>

    @if (filled($option->image_path))
        <div class="relative inline-block px-3 pb-2">
            <img
                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($option->image_path) }}"
                alt="Gambar opsi"
                class="max-h-24 rounded object-contain ring-1 ring-gray-950/5 dark:ring-white/10"
            />
            <button
                type="button"
                wire:click="removeOptionImage({{ $option->id }})"
                class="absolute end-1 top-0 rounded-full bg-gray-900 p-0.5 text-white shadow hover:bg-danger-600"
                title="Hapus gambar"
            >
                <x-filament::icon icon="heroicon-m-x-mark" class="h-3 w-3" />
            </button>
        </div>
    @endif

    @if ($isScored)
        <div x-show="showScores" x-cloak class="border-t border-gray-200 px-3 py-2.5 dark:border-white/10">
            @include('filament.admin.builder.partials.option-scores', [
                'option' => $option,
                'question' => $question,
                'dimensionOptions' => $dimensionOptions,
            ])
        </div>
    @endif
</div>
