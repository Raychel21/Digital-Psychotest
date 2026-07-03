{{-- ranking: urutkan seluruh opsi via drag & drop (SortableJS lewat direktif x-ranking) --}}
@php
    $rankedOptions = $this->rankingOptions($question);
@endphp

<div class="space-y-4">
    <div class="space-y-1">
        <p class="text-sm text-gray-600 dark:text-gray-300">
            Urutkan dari yang paling sesuai (atas) ke paling tidak sesuai (bawah).
        </p>
        <p class="text-xs text-gray-500 dark:text-gray-400">Geser kartu untuk mengurutkan.</p>
    </div>

    <ul x-ranking wire:key="ranking-{{ $question->id }}" class="space-y-2">
        @foreach ($rankedOptions as $option)
            <li
                data-option-id="{{ $option->id }}"
                wire:key="ranking-option-{{ $option->id }}"
                class="flex cursor-grab select-none items-center gap-3 rounded-lg border border-gray-200 bg-white p-3 transition hover:border-primary-400 active:cursor-grabbing dark:border-gray-700 dark:bg-gray-900"
            >
                <span
                    class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary-50 text-xs font-semibold text-primary-600 dark:bg-primary-950 dark:text-primary-400"
                >
                    {{ $loop->iteration }}
                </span>

                @include('filament.participant.pages.partials.take-test-option-image', ['option' => $option])

                <span class="text-sm text-gray-900 dark:text-white">{{ $option->label }}</span>

                <x-filament::icon icon="heroicon-o-bars-3" class="ms-auto h-5 w-5 shrink-0 text-gray-400" />
            </li>
        @endforeach
    </ul>
</div>

@error('state.ordered_option_ids')
    <p class="text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
@enderror
