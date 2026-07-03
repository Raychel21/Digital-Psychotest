{{-- multiple_choice: boleh memilih lebih dari satu --}}
<div class="space-y-2">
    <p class="text-xs text-gray-500 dark:text-gray-400">Pilih satu atau lebih jawaban.</p>

    @foreach ($question->options as $option)
        <label
            class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 p-3 transition hover:border-primary-400 hover:bg-primary-50 dark:border-gray-700 dark:hover:bg-primary-950"
        >
            <input
                type="checkbox"
                value="{{ $option->id }}"
                wire:model.live="state.option_ids"
                class="h-4 w-4 shrink-0 rounded border-gray-300 text-primary-600 focus:ring-primary-600"
            />

            @include('filament.participant.pages.partials.take-test-option-image', ['option' => $option])

            <span class="text-sm text-gray-900 dark:text-white">{{ $option->label }}</span>
        </label>
    @endforeach
</div>

@error('state.option_ids')
    <p class="text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
@enderror
