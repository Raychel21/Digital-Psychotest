@php
    $paletteIcons = [
        \App\Enums\QuestionType::SingleChoice->value => 'heroicon-o-check-circle',
        \App\Enums\QuestionType::MultipleChoice->value => 'heroicon-o-list-bullet',
        \App\Enums\QuestionType::Likert->value => 'heroicon-o-adjustments-horizontal',
        \App\Enums\QuestionType::MostLeast->value => 'heroicon-o-arrows-up-down',
        \App\Enums\QuestionType::Ranking->value => 'heroicon-o-numbered-list',
        \App\Enums\QuestionType::Text->value => 'heroicon-o-pencil-square',
    ];
@endphp

<div class="lg:sticky lg:top-20">
    <x-filament::section compact>
        <x-slot name="heading">Tambah soal</x-slot>
        <x-slot name="description">Klik untuk menambahkan ke bagian bawah kanvas.</x-slot>

        <div class="flex flex-col gap-2">
            @foreach (\App\Enums\QuestionType::cases() as $type)
                <button
                    type="button"
                    wire:click="addQuestion('{{ $type->value }}')"
                    wire:loading.attr="disabled"
                    class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-left text-sm font-medium text-gray-700 transition hover:border-primary-400 hover:bg-primary-50 hover:text-primary-700 dark:border-white/10 dark:bg-white/5 dark:text-gray-200 dark:hover:border-primary-500 dark:hover:bg-primary-500/10 dark:hover:text-primary-400"
                >
                    <x-filament::icon :icon="$paletteIcons[$type->value]" class="h-5 w-5 shrink-0 text-gray-400" />
                    <span>{{ $type->getLabel() }}</span>
                </button>
            @endforeach
        </div>
    </x-filament::section>
</div>
